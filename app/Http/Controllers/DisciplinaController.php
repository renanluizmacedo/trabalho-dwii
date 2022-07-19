<?php

namespace App\Http\Controllers;
use App\Models\Disciplina;
use App\Models\Curso;
use App\Models\Eixo;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class DisciplinaController extends Controller
{
    
    public function index()
    {
        $data = Disciplina::with(['curso'])->orderby('nome')->get();

        return view('disciplinas.index', compact(['data']));
    }

    
    public function create()
    {
        $curso = Curso::orderby('nome')->get();

        return view('disciplinas.create', compact(['curso']));
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


        $total = Disciplina::where('nome', mb_strtoupper($request->nome, 'UTF-8'))
            ->where('curso_id', $request->curso)
            ->count();

        if ($total > 0) {
            $msg = "Disciplina";
            $link = "disciplinas.index";
            return view('erros.duplicado', compact(['msg', 'link']));
        }

        $curso = Curso::find($request->curso);
        if (isset($curso)) {
            $obj = new Disciplina();
            $obj->nome = mb_strtoupper($request->nome, 'UTF-8');
            $obj->carga = $request->carga;
            $obj->curso()->associate($curso);
            $obj->save();
            return redirect()->route('disciplinas.index');
        }

        $msg = "Curso e/ou Área do Conhecimento";
        $link = "disciplinas.index";
        return view('erros.id', compact(['msg', 'link']));
    }

    public function edit($id)
    {
        $data = Disciplina::find($id);
        $curso = Curso::oderby('nome')->get();

        if (isset($data)) {
            return view('disciplinas.edit', compact(['data', 'curso']));
        } else {
            $msg = "Disciplina";
            $link = "disciplinas.index";
            return view('erros.id', compact(['msg', 'link']));
        }
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

        $curso = Curso::find($request->curso);
        $obj = Disciplina::find($id);

        if (isset($obj) && isset($curso)) {
            $obj->nome = mb_strtoupper($request->nome, 'UTF-8');
            $obj->carga = $request->carga;
            $obj->curso()->associate($curso);

            $obj->save();

            return redirect()->route('disciplinas.index');
        }
    }

    public function destroy($id)
    {
        $obj = Disciplina::find($id);

        if (isset($obj)) {
            $obj->delete();
        }

        

        return redirect()->route('disciplinas.index');
    }
}
