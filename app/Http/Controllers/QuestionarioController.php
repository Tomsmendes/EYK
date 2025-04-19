<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Aula;
use App\Models\Questionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuestionarioController extends Controller
{
    public function index(Curso $curso, Aula $aula)
    {
        $data['questionarios'] = Questionario::join('aulas', 'questionarios.aula_id', '=', 'aulas.id')->
        select(
            'questionarios.*',
            'aulas.title as a_nome'
        )->get();

        $data ['aulas'] = Aula::all();

        return view('admin.questionarios.index', $data);
    }

    public function store(Request $request, Curso $curso, Aula $aula)
    {
        $request->validate([
            'qt_name' => 'required|string|max:255',
            'qt_descricao' => 'nullable|string',
            'aula_id' => 'required|exists:aulas,id',
        ]);

        $questionario = new Questionario();
        $questionario->qt_name = $request->qt_name;
        $questionario->qt_descricao = $request->qt_descricao;
        $questionario->aula_id = $request->aula_id;
        $questionario->save();

        Session::flash('success', 'Questionário criado com sucesso!');
        return redirect()->route('questionarios.index', [$curso, $aula]);
    }

    public function update(Request $request, Curso $curso, Aula $aula, Questionario $questionario)
    {
        $request->validate([
            'qt_name' => 'required|string|max:255',
            'qt_descricao' => 'nullable|string',
            'aula_id' => 'required|exists:aulas,id',
        ]);

        $questionario->update([
            'qt_name' => $request->qt_name,
            'qt_descricao' => $request->qt_descricao,
            'aula_id' => $request->aula_id,
        ]);

        Session::flash('success', 'Questionário atualizado com sucesso!');
        return redirect()->route('questionarios.index', [$curso, $aula]);
    }

    public function destroy(Curso $curso, Aula $aula, Questionario $questionario)
    {
        $questionario->delete();
        Session::flash('success', 'Questionário excluído com sucesso!');
        return redirect()->route('questionarios.index', [$curso, $aula]);
    }

}