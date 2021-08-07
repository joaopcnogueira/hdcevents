<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index() {

        $nome = "Matheus";
        $idade = 29;
        $profissao = "Engenheiro de Software";
    
        $arr = [1, 2, 3, 4, 5];
    
        $nomes = ["Matheus", "Maria", "João", "Saulo"];
    
        return view('welcome', compact('nome', 'idade', 'profissao', 'arr', 'nomes'));
    }

    public function create() {
        return view('events.create');
    }
}
