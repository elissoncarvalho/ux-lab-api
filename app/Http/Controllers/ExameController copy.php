<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info('request api');
        $exames = [
            ['prefixo' => 'glicose', 'descricao' => 'Glicose', 'is_selected' => false],
            ['prefixo' => 'hemograma', 'descricao' => 'Hemograma', 'is_selected' => true],
            ['prefixo' => 'gama_gt', 'descricao' => 'Gama GT', 'is_selected' => false],
            ['prefixo' => 'urina_rotina', 'descricao' => 'Urina Rotina', 'is_selected' => false],
            ['prefixo' => 'acido_urico', 'descricao' => 'Ácido úrico', 'is_selected' => false],
            ['prefixo' => 'colesterol_total', 'descricao' => 'Colesterol Total', 'is_selected' => false],
            ['prefixo' => 'bilirrubina', 'descricao' => 'Bilirrubina', 'is_selected' => false],
            ['prefixo' => 'epf', 'descricao' => 'EPF', 'is_selected' => false],
            ['prefixo' => 'ureia', 'descricao' => 'Ureia', 'is_selected' => false],
            ['prefixo' => 'colesterol_fracoes', 'descricao' => 'Colesterol Frações', 'is_selected' => false],
            ['prefixo' => 'tgo_tgp', 'descricao' => 'TGO/TGP', 'is_selected' => false],
            ['prefixo' => 'sangue_oculto', 'descricao' => 'Sangue Oculto', 'is_selected' => false],
            ['prefixo' => 'creatina', 'descricao' => 'Creatina', 'is_selected' => false],
            ['prefixo' => 'triglicerides', 'descricao' => 'Triglicerides', 'is_selected' => false],
        ];

        return response($exames);
    }
}
