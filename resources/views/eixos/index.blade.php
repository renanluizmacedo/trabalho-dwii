<!-- Herda o layout padrão definido no template "main" -->
@extends('templates.main', ['titulo' => "Eixos/Áreas", 'rota' => "eixos.create"])
<!-- Preenche o conteúdo da seção "titulo" -->
@section('titulo') Eixos @endsection
<!-- Preenche o conteúdo da seção "conteudo" -->
@section('conteudo')

<div class="row">
    <div class="col">

        <!-- Utiliza o componente "datalist" criado -->
        <x-dataListEixo :title="'Eixos'" 
        :crud="'eixos'" 
        :header="['ID', 'NOME', 'AÇÕES']" 
        :fields="['id', 'nome']" 
        :data="$dados" 
        :hide="[true, false, true, false]" 
        :info="['id', 'nome']" 
        :remove="'nome'" />

    </div>
</div>
@endsection