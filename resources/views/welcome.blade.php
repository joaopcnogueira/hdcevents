@extends('layouts.main')

@section('title', 'HDC Events')

@section('content')
    <h1>Algum título</h1>
    <img src="{{ asset('img/banner.jpg') }}" alt="Banner">

    {{-- Diretivas do blade e variáveis --}}
    @if ($nome == "João")
        <p>O nome é {{ $nome }} e ele tem {{ $idade }} anos e trabalha como {{ $profissao }}</p>
    @elseif ($nome == "Matheus")
        <p>O nome é {{ $nome }} e ele tem {{ $idade }} anos e trabalha como {{ $profissao }}</p>
    @else
        <p>O nome não é {{ $nome }} e ele tem {{ $idade }} anos e trabalha como {{ $profissao }}</p>
    @endif

    @foreach ($arr as $item)
        <ul>
            <li>{{ $item }}</li>
        </ul>
    @endforeach

    {{-- Executando código PHP direto na view --}}
    @php
        $texto = "PHP direto na View com Blade";
        echo $texto;
    @endphp

    <!-- Comentário do HTML: aparece na View-->
    {{-- Comentário do Blade: Não aparece na View --}}

    @foreach ($nomes as $nome)
        <p>{{ $loop->index}} -> {{ $nome }}</p>
    @endforeach
@endsection
