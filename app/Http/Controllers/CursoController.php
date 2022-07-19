<?php

namespace App\Http\Controllers;
use App\Models\Curso;
use App\Models\Eixo;

use Illuminate\Http\Request;



class CursoController extends Controller
{
    
    public function index()
    {
        $dados = Curso::all();

        return view('cursos.index', compact('dados'));
    }

    public function create()
    {
        $ex = Eixo::all();

        return view('cursos.create', compact(['ex']));
    }

   
    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|max:50|min:10|unique:cursos',
            'sigla' => 'required|max:8|min:2',
            'tempo' => 'required|max:2|min:1',
            'eixo_id' => 'required'
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
            'sigla' => $request->sigla,
            'tempo' => $request->tempo,
            'eixo_id' => $request->eixo_id,
        ]);

        return redirect()->route('cursos.index');
    }
    public function edit($id)
    {
        $dados = Curso::find($id);
        $ex = Eixo::all();

        if (!isset($dados)) {
            return "<h1>ID: $id não encontrado!</h1>";
        }

        return view('cursos.edit', compact(['dados', 'ex']));
    }

    public function update(Request $request, $id)
    {
        
        $obj = Curso::find($id);

        if (!isset($obj)) {
            return "<h1>ID: $id não encontrado!</h1>";
        }

        if ($request->id == $obj->id) {
            $regras = [
                'nome' => 'required|max:50|min:10|unique:cursos',
                'sigla' => 'required|max:8|min:2',
                'tempo' => 'required|max:2|min:1',
                'eixo_id' => 'required'
            ];
        }else{
            $regras = [
                'nome' => 'required|max:50|min:10|unique:cursos',
                'sigla' => 'required|max:8|min:2',
                'tempo' => 'required|max:2|min:1',
                'eixo_id' => 'required'
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
            'sigla' => $request->sigla,
            'tempo' => $request->tempo,
            'eixo' => $request->eixo,
        ]);

        $obj->save();

        return redirect()->route('cursos.index');
    }

    public function destroy($id)
    {
        $obj = Curso::find($id);

        if (!isset($obj)) {
            return "<h1>ID: $id não encontrado!</h1>";
        }

        $obj->destroy($id);

        return redirect()->route('cursos.index');
    
    }
}
