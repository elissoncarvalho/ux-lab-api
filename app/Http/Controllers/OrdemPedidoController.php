<?php

namespace App\Http\Controllers;

use App\Models\OrdemPedido;
use App\Models\Endereco;
use App\Services\ExceptionHandler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrdemPedidoController extends Controller
{
    public function index()
    {
        try {
            $ordemPedido = OrdemPedido::with('cliente')
            ->with('empresa')
            ->with('empresa.endereco')
            ->with('cliente.endereco')
            ->with('convenio')
            ->with('status')
            ->with('exames')
            ->get();

            return response($ordemPedido, 404);
        } catch (\Exception $e) {
            return ExceptionHandler::process(
                $e,
                'Error ao listar Ordem Pedidos.'
            );
        }
    }

    public function show(int $id)
    {
        try {
            $cliente = OrdemPedido::with('endereco')->find($id);

            if (empty($cliente)) {
                return response(['msg' => 'Não foi possível localizar o OrdemPedido.'], 404);
            }

            return response($cliente);
        } catch (\Exception $e) {
            return ExceptionHandler::process(
                $e,
                'Error ao Consultar OrdemPedido.'
            );
        }
    }

    public function destroy(int $id)
    {
        try {
            DB::beginTransaction();
            $cliente = OrdemPedido::withTrashed()->find($id);

            if (empty($cliente)) {
                return response(['msg' => 'Não foi possível localizar o OrdemPedido.'], 404);
            }

            if ($cliente->trashed()) {
                $cliente->restore();
                $msg = 'OrdemPedido ativado com sucesso';
            } else {
                $cliente->delete();
                $msg = 'OrdemPedido inativado com sucesso';
            }

            DB::commit();
            return response(['msg' => $msg], 200);;
        } catch (\Exception $e) {
            DB::rollBack();
            return ExceptionHandler::process(
                $e,
                'Error ao Ativar \ Inativar OrdemPedido.'
            );
        }
    }

    public function store(Request $request)
    {
        Log::info(json_encode($request->all()));
        Log::info(json_encode($request->nome));
        return response($request->all(), 404);
        try {
            DB::beginTransaction();

            $cliente = OrdemPedido::where('email', $request->email)->orWhere('cpf', $request->cpf)->withTrashed()->count();

            if ($cliente > 0) {
                return response(['msg' => 'Email ou CPF já esta sendo utilizado.'], 409);
            }

            $codCliente = OrdemPedido::orderBy('cod_cliente', 'desc')->first()->cod_cliente + 1;

            $endereco = new Endereco();
            $endereco->endereco = $request->endereco['endereco'];
            $endereco->bairro = $request->endereco['bairro'];
            $endereco->cidade = $request->endereco['cidade'];
            $endereco->uf = $request->endereco['uf'] ?? 'MG';
            $endereco->complemento = $request->endereco['complemento'] ?? null;
            $endereco->pais = $request->endereco['pais'] ?? 'Brasil';
            $endereco->numero = $request->endereco['numero'];
            $endereco->cep = $request->endereco['cep'] ?? '35600000';
            $endereco->save();

            $cliente = new OrdemPedido();
            $cliente->cod_cliente = $codCliente;
            $cliente->nome = $request->nome;
            $cliente->email = $request->email;
            $cliente->cpf = $request->cpf;
            $cliente->sexo = $request->sexo;
            $cliente->telefone = $request->telefone;
            $cliente->senha = encrypt($request->senha);
            $cliente->data_nascimento = Carbon::parse($request->data_nascimento)->format('Y-m-d');
            $cliente->endereco_id = $endereco->id;
            $cliente->image_id = null;
            $cliente->save();

            DB::commit();
            return response($this->show($cliente->id)->original, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return ExceptionHandler::process(
                $e,
                'Error ao Cadastrar OrdemPedido.'
            );
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            DB::beginTransaction();

            $cliente = OrdemPedido::where('email', $request->email)->orWhere('cpf', $request->cpf)->withTrashed()->count();

            if ($cliente > 0) {
                return response(['msg' => 'Email ou CPF já esta sendo utilizado.'], 409);
            }

            $cliente = OrdemPedido::find($id);

            if (empty($cliente)) {
                return response(['msg' => 'Não foi possível localizar o OrdemPedido.'], 404);
            }

            $cliente->nome = $request->nome ?? $cliente->nome;
            $cliente->email = $request->email ?? $cliente->email;
            $cliente->cpf = $request->cpf ?? $cliente->cpf;
            $cliente->sexo = $request->sexo ?? $cliente->sexo;
            $cliente->telefone = $request->telefone ?? $cliente->telefone;
            $cliente->senha = encrypt($request->senha) ?? $cliente->senha;
            $cliente->data_nascimento = Carbon::parse(
                $request->data_nascimento
            )->format('Y-m-d') ?? $cliente->data_nascimento;
            $cliente->endereco->endereco = $request->endereco['endereco'] ?? $cliente->endereco->endereco;
            $cliente->endereco->bairro = $request->endereco['bairro'] ?? $cliente->endereco->bairro;
            $cliente->endereco->cidade = $request->endereco['cidade'] ?? $cliente->endereco->cidade;
            $cliente->endereco->numero = $request->endereco['numero'] ?? $cliente->endereco->numero;
            $cliente->save();

            DB::commit();
            return response($this->show($cliente->id)->original);
        } catch (\Exception $e) {
            DB::rollBack();
            return ExceptionHandler::process(
                $e,
                'Error ao Atualizar OrdemPedido.'
            );
        }
    }
}
