<?php

use App\Models\Cliente;
use App\Models\Convenio;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\Exame;
use App\Models\OrdemPedido;
use App\Models\OrdemPedidoExame;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Preeche Convenios
        $convenio = new Convenio();
        $convenio->nome_razao_social = "Unimed";
        $convenio->cnpj = '63444567000177';
        $convenio->save();
        $convenio = new Convenio();
        $convenio->nome_razao_social = "SANTA HELENA";
        $convenio->cnpj = '56892325000180';
        $convenio->save();
        $convenio = new Convenio();
        $convenio->nome_razao_social = "SUS";
        $convenio->cnpj = null;
        $convenio->save();

        // Preeche Status
        $status = new Status();
        $status->prefixo = 'aguardando_analise';
        $status->descricao = 'Aguardando Análise';
        $status->cor_destaque = 'Colors.blue';
        $status->padrao_sistema = true;
        $status->save();
        $status = new Status();
        $status->prefixo = 'aguardando_coleta';
        $status->descricao = 'Aguardando Coleta';
        $status->cor_destaque = 'Colors.blue';
        $status->padrao_sistema = true;
        $status->save();
        $status = new Status();
        $status->prefixo = 'concluido';
        $status->descricao = 'Concluído';
        $status->cor_destaque = 'Colors.red[300]';
        $status->padrao_sistema = true;
        $status->save();
        $status = new Status();
        $status->prefixo = 'pendente';
        $status->descricao = 'Pendente';
        $status->cor_destaque = 'Colors.blue';
        $status->padrao_sistema = true;
        $status->save();

        // Preeche Empresa
        $endereco = new Endereco();
        $endereco->endereco = 'R. Fidélis Teixeira Campos';
        $endereco->bairro = 'Centro';
        $endereco->cidade = 'Bom Despacho';
        $endereco->uf = 'MG';
        $endereco->complemento = '';
        $endereco->pais = 'Brasil';
        $endereco->numero = 95;
        $endereco->cep = 35600000;
        $endereco->save();
        $empresa = new Empresa();
        $empresa->nome_razao_social = 'BioLab Análises Clínicas';
        $empresa->nome_fantasia = 'BioLab Análises Clínicas';
        $empresa->email = 'contato@biolab.com.br';
        $empresa->cnpj = '04616151000120';
        $empresa->telefone = '37666999666';
        $empresa->filial = false;
        $empresa->endereco_id = $endereco->id;
        $empresa->save();

        // Preeche Cliente
        $endereco = new Endereco();
        $endereco->endereco = 'R. Clodoaldo de Oliveira';
        $endereco->bairro = 'Alfa Ville';
        $endereco->cidade = 'Bom Despacho';
        $endereco->uf = 'MG';
        $endereco->complemento = 'Casa na esquina';
        $endereco->pais = 'Brasil';
        $endereco->numero = 133;
        $endereco->cep = 35600000;
        $endereco->save();
        $cliente = new Cliente();
        $cliente->cod_cliente = 20190101;
        $cliente->nome = 'Maria Luisa Sousa';
        $cliente->email = 'maria.sousa@email.com';
        $cliente->cpf = '92171035439';
        $cliente->sexo = true;
        $cliente->telefone = '379991589666';
        $cliente->senha = encrypt('admin');
        $cliente->data_nascimento = Carbon::parse('11-10-1997')->format('Y-m-d');
        $cliente->endereco_id = $endereco->id;
        $cliente->image_id = null;
        $cliente->save();

        // Preenche Exmes
        $exames = [
            ['prefixo' => 'glicose', 'descricao' => 'Glicose'],
            ['prefixo' => 'hemograma', 'descricao' => 'Hemograma'],
            ['prefixo' => 'gama_gt', 'descricao' => 'Gama GT'],
            ['prefixo' => 'urina_rotina', 'descricao' => 'Urina Rotina'],
            ['prefixo' => 'acido_urico', 'descricao' => 'Ácido úrico'],
            ['prefixo' => 'colesterol_total', 'descricao' => 'Colesterol Total'],
            ['prefixo' => 'bilirrubina', 'descricao' => 'Bilirrubina'],
            ['prefixo' => 'epf', 'descricao' => 'EPF'],
            ['prefixo' => 'ureia', 'descricao' => 'Ureia'],
            ['prefixo' => 'colesterol_fracoes', 'descricao' => 'Colesterol Frações'],
            ['prefixo' => 'tgo_tgp', 'descricao' => 'TGO/TGP'],
            ['prefixo' => 'sangue_oculto', 'descricao' => 'Sangue Oculto'],
            ['prefixo' => 'creatina', 'descricao' => 'Creatina'],
            ['prefixo' => 'triglicerides', 'descricao' => 'Triglicerides'],
        ];
        foreach ($exames as $item) {
            $exame = new Exame();
            $exame->prefixo = $item['prefixo'];
            $exame->descricao = $item['descricao'];
            $exame->save();
        }

        // Preeche Ordem de Pedidos
        $ordemPedido = new OrdemPedido();
        $ordemPedido->id_ordem_pedido = 20190000;
        $ordemPedido->status_id = $status->id;
        $ordemPedido->cliente_id = $cliente->id;
        $ordemPedido->empresa_id = $empresa->id;
        $ordemPedido->convenio_id = $convenio->id;
        $ordemPedido->data_coleta = Carbon::now()->format('Y-m-d');
        $ordemPedido->data_exame = Carbon::now()->format('Y-m-d');
        $ordemPedido->preparo_exame = true;
        $ordemPedido->save();

        $exame = Exame::wherePrefixo('hemograma')->firstOrFail();
        $ordemPedidoExame = new OrdemPedidoExame();
        $ordemPedidoExame->ordem_pedido_id = $ordemPedido->id;
        $ordemPedidoExame->exame_id = $exame->id;
        $ordemPedidoExame->save();

        $exame = Exame::wherePrefixo('urina_rotina')->firstOrFail();
        $ordemPedidoExame = new OrdemPedidoExame();
        $ordemPedidoExame->ordem_pedido_id = $ordemPedido->id;
        $ordemPedidoExame->exame_id = $exame->id;
        $ordemPedidoExame->save();

        $exame = Exame::wherePrefixo('epf')->firstOrFail();
        $ordemPedidoExame = new OrdemPedidoExame();
        $ordemPedidoExame->ordem_pedido_id = $ordemPedido->id;
        $ordemPedidoExame->exame_id = $exame->id;
        $ordemPedidoExame->save();

        // 
        $ordemPedido = new OrdemPedido();
        $ordemPedido->id_ordem_pedido = 20190001;
        $ordemPedido->status_id = $status->id;
        $ordemPedido->cliente_id = $cliente->id;
        $ordemPedido->empresa_id = $empresa->id;
        $ordemPedido->convenio_id = $convenio->id;
        $ordemPedido->data_coleta = Carbon::now()->format('Y-m-d');
        $ordemPedido->data_exame = Carbon::now()->format('Y-m-d');
        $ordemPedido->preparo_exame = false;
        $ordemPedido->save();

        $exame = Exame::wherePrefixo('urina_rotina')->firstOrFail();
        $ordemPedidoExame = new OrdemPedidoExame();
        $ordemPedidoExame->ordem_pedido_id = $ordemPedido->id;
        $ordemPedidoExame->exame_id = $exame->id;
        $ordemPedidoExame->save();

        $exame = Exame::wherePrefixo('epf')->firstOrFail();
        $ordemPedidoExame = new OrdemPedidoExame();
        $ordemPedidoExame->ordem_pedido_id = $ordemPedido->id;
        $ordemPedidoExame->exame_id = $exame->id;
        $ordemPedidoExame->save();

        // 
        $ordemPedido = new OrdemPedido();
        $ordemPedido->id_ordem_pedido = 20190002;
        $ordemPedido->status_id = $status->id;
        $ordemPedido->cliente_id = $cliente->id;
        $ordemPedido->empresa_id = $empresa->id;
        $ordemPedido->convenio_id = $convenio->id;
        $ordemPedido->data_coleta = Carbon::now()->format('Y-m-d');
        $ordemPedido->data_exame = Carbon::now()->format('Y-m-d');
        $ordemPedido->preparo_exame = false;
        $ordemPedido->save();

        $exame = Exame::wherePrefixo('urina_rotina')->firstOrFail();
        $ordemPedidoExame = new OrdemPedidoExame();
        $ordemPedidoExame->ordem_pedido_id = $ordemPedido->id;
        $ordemPedidoExame->exame_id = $exame->id;
        $ordemPedidoExame->save();

        $exame = Exame::wherePrefixo('epf')->firstOrFail();
        $ordemPedidoExame = new OrdemPedidoExame();
        $ordemPedidoExame->ordem_pedido_id = $ordemPedido->id;
        $ordemPedidoExame->exame_id = $exame->id;
        $ordemPedidoExame->save();

        // //
        $ordemPedido = new OrdemPedido();
        $ordemPedido->id_ordem_pedido = 20190003;
        $ordemPedido->status_id = $status->id;
        $ordemPedido->cliente_id = $cliente->id;
        $ordemPedido->empresa_id = $empresa->id;
        $ordemPedido->convenio_id = $convenio->id;
        $ordemPedido->data_coleta = Carbon::now()->format('Y-m-d');
        $ordemPedido->data_exame = Carbon::now()->format('Y-m-d');
        $ordemPedido->preparo_exame = false;
        $ordemPedido->save();

        $exame = Exame::wherePrefixo('hemograma')->firstOrFail();
        $ordemPedidoExame = new OrdemPedidoExame();
        $ordemPedidoExame->ordem_pedido_id = $ordemPedido->id;
        $ordemPedidoExame->exame_id = $exame->id;
        $ordemPedidoExame->save();

        $exame = Exame::wherePrefixo('epf')->firstOrFail();
        $ordemPedidoExame = new OrdemPedidoExame();
        $ordemPedidoExame->ordem_pedido_id = $ordemPedido->id;
        $ordemPedidoExame->exame_id = $exame->id;
        $ordemPedidoExame->save();

        // //
        $ordemPedido = new OrdemPedido();
        $ordemPedido->id_ordem_pedido = 20190004;
        $ordemPedido->status_id = $status->id;
        $ordemPedido->cliente_id = $cliente->id;
        $ordemPedido->empresa_id = $empresa->id;
        $ordemPedido->convenio_id = $convenio->id;
        $ordemPedido->data_coleta = Carbon::now()->format('Y-m-d');
        $ordemPedido->data_exame = Carbon::now()->format('Y-m-d');
        $ordemPedido->preparo_exame = false;
        $ordemPedido->save();

        $exame = Exame::wherePrefixo('hemograma')->firstOrFail();
        $ordemPedidoExame = new OrdemPedidoExame();
        $ordemPedidoExame->ordem_pedido_id = $ordemPedido->id;
        $ordemPedidoExame->exame_id = $exame->id;
        $ordemPedidoExame->save();

        $exame = Exame::wherePrefixo('epf')->firstOrFail();
        $ordemPedidoExame = new OrdemPedidoExame();
        $ordemPedidoExame->ordem_pedido_id = $ordemPedido->id;
        $ordemPedidoExame->exame_id = $exame->id;
        $ordemPedidoExame->save();

        // //
        $ordemPedido = new OrdemPedido();
        $ordemPedido->id_ordem_pedido = 20190005;
        $ordemPedido->status_id = $status->id;
        $ordemPedido->cliente_id = $cliente->id;
        $ordemPedido->empresa_id = $empresa->id;
        $ordemPedido->convenio_id = $convenio->id;
        $ordemPedido->data_coleta = Carbon::now()->format('Y-m-d');
        $ordemPedido->data_exame = Carbon::now()->format('Y-m-d');
        $ordemPedido->preparo_exame = false;
        $ordemPedido->save();

        $exame = Exame::wherePrefixo('hemograma')->firstOrFail();
        $ordemPedidoExame = new OrdemPedidoExame();
        $ordemPedidoExame->ordem_pedido_id = $ordemPedido->id;
        $ordemPedidoExame->exame_id = $exame->id;
        $ordemPedidoExame->save();

        $exame = Exame::wherePrefixo('epf')->firstOrFail();
        $ordemPedidoExame = new OrdemPedidoExame();
        $ordemPedidoExame->ordem_pedido_id = $ordemPedido->id;
        $ordemPedidoExame->exame_id = $exame->id;
        $ordemPedidoExame->save();
    }
}
