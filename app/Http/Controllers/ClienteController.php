<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        sleep(3);
        $cliente = [
            'cod_cliente' => 00021,
            'nome' => 'Luísa Braga Santos API',
            'cpf' => '123.123.123-32',
            'email' => 'luísa.santos@email.com',
            'url_image_perfil' => 'assets/images/avatar_girl.jpg',
        ];
        return response($cliente);
    }

    public function store(Request $request)
    {
        Log::info(json_encode($request->all()));

        return response($request->all(), 202);
    }
}
