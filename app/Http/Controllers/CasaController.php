<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\User;

class CasaController extends Controller
{
    public function index()
    {
        // Últimos 6 cursos cadastrados
        $cursos = Curso::latest()->take(6)->get();

        // Últimos 6 usuários em destaque
        $usuarios = User::latest()->take(6)->get();

        return view('Site.Pages.casa.index', compact('cursos', 'usuarios'));
    }
    //Ver perfil
     public function show($id)
    {
        // Busca o usuário pelo ID
        $user = User::findOrFail($id);

        // Pega todos os cursos do usuário
        $cursos = Curso::where('user_id', $user->id)->latest()->get();

        return view('Site.Pages.perfil.show', compact('user', 'cursos'));
    }
}
