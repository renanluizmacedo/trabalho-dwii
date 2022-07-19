<?php

namespace App\Http\Controllers;
use App\Models\Disciplina;
use App\Models\Curso;

use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
    
    public function index()
    {
        $dados = Disciplina::all();

        return view('disciplinas.index', compact('dados'));
    }

    
    public function create()
    {
        $cur = Curso::all();

        return view('disciplinas.create', compact(['cur']));
    }

   
    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|max:100|min:10|unique:disciplinas',
            'curso_id' => 'required',
            'carga' => 'required|max:12|min:1'     
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
            "unique" => "Já existe um Veterinário cadastrado com esse [:attribute]!"
        ];


        $request->validate($regras, $msgs);


        Curso::create([
            
            'nome' => mb_strtoupper($request->nome, 'UTF8'),
            'curso_id' => $request->curso_id,
            'carga' => $request->carga,
        ]);

        return redirect()->route('disciplinas.index');
    }

    public function edit($id)
    {
        $dados = Disciplina::find($id);
        $cur = Curso::all();

        if (!isset($dados)) {
            return "<h1>ID: $id não encontrado!</h1>";
        }

        return view('disciplinas.edit', compact(['dados', 'cur']));
    }

    public function update(Request $request, $id)
    {
        $obj = Disciplina::find($id);

        if (!isset($obj)) {
            return "<h1>ID: $id não encontrado!</h1>";
        }

        if ($request->id == $obj->id) {
            $regras = [
                'nome' => 'required|max:100|min:10|unique:disciplinas',
                'curso_id' => 'required',
                'carga' => 'required|max:12|min:1'  
            ];
        }else{
            $regras = [
                'nome' => 'required|max:100|min:10|unique:disciplinas',
                'curso_id' => 'required',
                'carga' => 'required|max:12|min:1'  
            ];
        }

        $msgs = [
            "required" => "O preenchimento do campo Especialidade é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
            "unique" => "Já existe um Curso cadastrado com esse [:attribute]!"
        ];

        $request->validate($regras, $msgs);

        $obj->fill([
            'nome' => mb_strtoupper($request->nome, 'UTF8'),
            'curso' => $request->curso,
            'carga' => $request->carga,
        ]);

        $obj->save();

        return redirect()->route('disciplinas.index');
    }

    public function destroy($id)
    {
        $obj = Disciplina::find($id);

        if (!isset($obj)) {
            return "<h1>ID: $id não encontrado!</h1>";
        }

        $obj->destroy($id);

        return redirect()->route('disciplinas.index');
    }
}
