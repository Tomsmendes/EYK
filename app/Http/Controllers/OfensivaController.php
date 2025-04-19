<?php

namespace App\Http\Controllers;

use App\Models\Ofensiva;
use Illuminate\Http\Request;

class OfensivaController extends Controller
{
    public function index()
    {
        $ofensivas = Ofensiva::all();
        return view('admin.ofensivas.index', compact('ofensivas'));
    }

    public function create()
    {
        return view('admin.ofensivas.create');
    }

    public function store(Request $request)
    {
        Ofensiva::create($request->all());

        return redirect()->route('ofensivas.index');
    }

    public function edit(Ofensiva $ofensiva)
    {
        return view('admin.ofensivas.edit', compact('ofensiva'));
    }

    public function update(Request $request, $id)
    {
        $ofensivas = Ofensiva::findOrFail($id); 
    
        $request->validate([
            'titulo' => 'required|string',
            'data' => 'required|date',
            'descricao' => 'required|string',
        ]);
    
        $data = $request->all();
    
        $ofensivas->update($data);

        return redirect()->route('ofensivas.index')->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy(Ofensiva $ofensiva)
    {
        $ofensiva->delete();
        return redirect()->route('ofensivas.index')->with('success', 'Dia de Ofensiva removido!');
    }
}

