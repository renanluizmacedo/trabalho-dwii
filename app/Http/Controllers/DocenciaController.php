<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Professor;
use App\Models\Disciplina;
use App\Models\Docencia;


use Illuminate\Http\Request;

class DocenciaController extends Controller
{
    
    public function index()
    {
        $curso  = Curso::with(['eixo']);

        $disciplina = Disciplina::with(['curso'])
            ->orderBy('curso_id')->orderBy('id')->get();

        $prof = Professor::orderBy('id')->get();

        return view('docencias.index', compact(['prof', 'disciplina', 'curso']));
    }

    
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $rules = [
            'PROFESSOR_ID_SELECTED' => 'required',
        ];
        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($rules, $msgs);

        $ids_prof = $request->PROFESSOR_ID_SELECTED;
        $disciplina = $request->DISCIPLINA;


        for ($i = 0; $i < count($request->DISCIPLINA); $i++) {
            $doc = new Docencia();
            $doc->professor_id = $ids_prof[$i];
            $doc->disciplina_id = $disciplina[$i];
            $doc->save();
        }

        return redirect()->route('disciplinas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
