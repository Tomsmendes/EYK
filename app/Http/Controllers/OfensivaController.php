<?php

namespace App\Http\Controllers;

use App\Models\Ofensiva;
use App\Models\User; // Adicionando o model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfensivaController extends Controller
{
    public function index()
    {
        $data['ofensivas'] = Ofensiva::join('users', 'ofensivas.user_id', '=', 'users.id')
            ->select('ofensivas.*', 'users.name as user_name')
            ->get();

        $data['users'] = User::all(); // Obtendo todos os usuários para o select no formulário

        return view('admin.ofensivas.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'data' => 'required|date',
            'descricao' => 'required',
            'user_id' => 'required', // Alterando para user_id
        ]);

        $ofensiva = new Ofensiva();
        $ofensiva->titulo = $request->titulo;
        $ofensiva->data = $request->data;
        $ofensiva->descricao = $request->descricao;
        $ofensiva->user_id = $request->user_id; // Salvando o user_id
        $ofensiva->save();

        return redirect()->route('ofensivas.index')->with('success', 'Ofensiva criada com sucesso!');
    }

    public function update(Request $request, Ofensiva $ofensiva)
    {
        $request->validate([
            'titulo' => 'required',
            'data' => 'required|date',
            'descricao' => 'required',
            'user_id' => 'required', // Alterando para user_id
        ]);

        $ofensiva->titulo = $request->titulo;
        $ofensiva->data = $request->data;
        $ofensiva->descricao = $request->descricao;
        $ofensiva->user_id = $request->user_id; // Atualizando o user_id
        $ofensiva->save();

        return redirect()->route('ofensivas.index')->with('success', 'Ofensiva atualizada com sucesso!');
    }

    public function destroy(Ofensiva $ofensiva)
    {
        $ofensiva->delete();
        return redirect()->route('ofensivas.index')->with('success', 'Ofensiva excluída com sucesso!');
    }
}
