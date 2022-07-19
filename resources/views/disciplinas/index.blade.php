<!-- Herda o layout padrão definido no template "main" -->
@extends('templates.main', ['titulo' => "Disciplinas", 'rota' => "disciplinas.create"])
<!-- Preenche o conteúdo da seção "titulo" -->
@section('titulo') - Disciplinas @endsection
<!-- Preenche o conteúdo da seção "conteudo" -->
@section('conteudo')

    <div class="row">
        <div class="col">
            
            <!-- Utiliza o componente "datalist" criado -->
            <x-dataListDisciplina
                :header="[ 'NOME', 'CURSO', 'CARGA', 'AÇÕES']" 
                :data="$dados"
                :hide="[ false, true, true,false]" 
            />

        </div>
    </div>
@endsection