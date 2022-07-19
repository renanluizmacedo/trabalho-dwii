<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eixo;

class EixoController extends Controller
{
    
    public function index()
    {
        $data = Eixo::orderby('nome')->get();

        return view('eixos.index', compact(['data']));
    }

    
    public function create()
    {
        return view('eixos.create');
    }

   
    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|max:100|min:10',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
            "unique" => "Já existe um Eixo cadastrado com esse [:attribute]!"
        ];

        $request->validate($regras, $msgs);

        Eixo::create([

            'nome' => mb_strtoupper($request->nome, 'UTF-8'),
        ]);

        return redirect()->route('eixos.index');
    }

    public function edit($id)
    {
        $data = Eixo::find($id);

        if(!isset($data)){
            return "<h1>ID: $id não encontrado!</h1>";
        }

        return view('eixos.edit', compact(['data']));
    }

  
    public function update(Request $request, $id)
    {
        $obj = Eixo::find($id);

        $regras = [
            'nome' => 'required|max:100|min:10'
        ];

       if (!isset($obj)) {
            return "<h1>ID: $id não encontrado!</h1>";
        }

        if (trim($request->nome) == trim($obj->nome)) {
            $regras = [
                'nome' => 'required|max:100|min:10'
            ]; 
        } 

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
            "unique" => "Já existe um Cliente cadastrado com esse [:attribute]!"
        ];

        $request->validate($regras, $msgs);

       
        $obj = Eixo::find($id);
        if (isset($obj)) {
            $obj->nome = mb_strtoupper($request->nome, 'UTF-8');
            $obj->save();
        }

       

        return redirect()->route('eixos.index');
    }

    
    public function destroy($id)
    {
        $obj = Eixo::find($id);

        
        if (isset($obj)) {
            $obj->delete();
        }

        return redirect()->route('eixos.index');
    }
}
