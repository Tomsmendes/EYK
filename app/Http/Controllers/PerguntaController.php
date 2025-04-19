<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Aula;
use App\Models\Questionario;
use App\Models\Pergunta;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class PerguntaController extends Controller
{
    public function index()
    {
        $data['perguntas'] = Pergunta::join('questionarios', 'perguntas.questionario_id', '=', 'questionarios.id')
            ->select('perguntas.*', 'questionarios.qt_name as q_nome')
            ->get();

        $data['questionarios'] = Questionario::all();

        return view('admin.perguntas.index', $data);
    }

    public function store(Request $request, Curso $curso, Aula $aula, Questionario $questionario)
    {
        $request->validate([
            'pg_texto' => 'required|string|max:255',  // Corrigido para 'pg_texto'
            'questionario_id' => 'required',
        ]);

        $pergunta = new Pergunta();
        $pergunta->pg_texto = $request->pg_texto;  // Corrigido para 'pg_texto'
        $pergunta->questionario_id = $request->questionario_id;
        $pergunta->save();

        Session::flash('success', 'Pergunta criada com sucesso!');
        return redirect()->route('perguntas.index', [$curso, $aula]);
    }

    public function update(Request $request, Curso $curso, Aula $aula, Questionario $questionario, Pergunta $pergunta)
    {
        $request->validate([
            'pg_texto' => 'required|string|max:255',  // Corrigido para 'pg_texto'
            'questionario_id' => 'required',
        ]);

        $pergunta->pg_texto = $request->pg_texto;  // Corrigido para 'pg_texto'
        $pergunta->questionario_id = $request->questionario_id;
        $pergunta->save();

        Session::flash('success', 'Pergunta atualizada com sucesso!');
        return redirect()->route('perguntas.index', [$curso, $aula]);
    }

    public function destroy(Curso $curso, Aula $aula, Questionario $questionario, Pergunta $pergunta)
    {
        $pergunta->delete();
        return redirect()->route('perguntas.index', [$curso, $aula, $questionario])->with('success', 'Pergunta excluída com sucesso!');
    }
}
