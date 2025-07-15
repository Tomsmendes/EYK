<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Aula;
use App\Models\Questionario;
use App\Models\Pergunta;
use App\Models\Resposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RespostaController extends Controller
{
    public function index(Curso $curso, Aula $aula, Questionario $questionario, Pergunta $pergunta)
    {
        // Corrigindo a junção entre respostas e perguntas
        $data['respostas'] = Resposta::join('perguntas', 'respostas.pergunta_id', '=', 'perguntas.id')
            ->select('respostas.*', 'perguntas.pg_texto as p_nome')
            ->get();

        // Obtendo todas as perguntas
        $data['perguntas'] = Pergunta::all();

        // Retornando a view com os dados
        return view('Site.Pages.respostas.index', $data);
    }

    public function store(Request $request, Curso $curso, Aula $aula, Questionario $questionario, Pergunta $pergunta)
    {
        $request->validate([
            'rp_texto' => 'required|string|max:255',
            'is_correct' => 'required|boolean',
            'pergunta_id' => 'required|exists:perguntas,id',
        ]);

        // Criando uma nova resposta
        $resposta = new Resposta();
        $resposta->rp_texto = $request->rp_texto;  
        $resposta->is_correct = $request->is_correct; 
        $resposta->pergunta_id = $request->pergunta_id;
        $resposta->save();

        Session::flash('success', 'Resposta criada com sucesso!');
        return redirect()->route('respostas.index', [$curso, $aula, $questionario, $pergunta]);
    }

    public function update(Request $request, Curso $curso, Aula $aula, Questionario $questionario, Pergunta $pergunta, Resposta $resposta)
    {
        $request->validate([
            'rp_texto' => 'required|string|max:255',
            'is_correct' => 'required|boolean',
            'pergunta_id' => 'required|exists:perguntas,id',
        ]);

        // Atualizando a resposta existente
        $resposta->rp_texto = $request->rp_texto;  
        $resposta->is_correct = $request->is_correct; 
        $resposta->pergunta_id = $request->pergunta_id;
        $resposta->save();

        Session::flash('success', 'Resposta atualizada com sucesso!');
        return redirect()->route('respostas.index', [$curso, $aula, $questionario, $pergunta]);
    }

    public function destroy(Curso $curso, Aula $aula, Questionario $questionario, Pergunta $pergunta, Resposta $resposta)
    {
        // Excluindo a resposta
        $resposta->delete();
        Session::flash('success', 'Resposta excluída com sucesso!');
        
        return redirect()->route('respostas.index', [$curso, $aula, $questionario, $pergunta]);
    }
}
