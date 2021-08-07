<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $nome = "Matheus";
    $idade = 29;
    $profissao = "Engenheiro de Software";

    $arr = [1, 2, 3, 4, 5];

    $nomes = ["Matheus", "Maria", "João", "Saulo"];

    return view('welcome', compact('nome', 'idade', 'profissao', 'arr', 'nomes'));
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/products', function () {
    return view('products');
});
