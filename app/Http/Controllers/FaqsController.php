<?php

namespace App\Http\Controllers;

use App\Models\faqs;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = faqs::all();
        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category_f' => 'required|string',
            'order' => 'nullable|numeric',
        ]);

        $data = $request->all();

        faqs::create($data);

        return redirect()->route('faqs.index')->with('success', 'Curso criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(faqs $faqs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $faqs = faqs::where('id',$id)->first();

        return view('admin.faqs.edit', compact('faqs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $faqs = faqs::findOrFail($id); 
    
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category_f' => 'required|string',
            'order' => 'nullable|numeric',
        ]);
    
        $data = $request->all();
    
        $faqs->update($data);

        return redirect()->route('faqs.index')->with('success', 'Curso atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $faqs = faqs::where('id',$id)->first();
        $faqs->delete();

        return redirect()->route('faqs.index')->with('success', 'Curso deletado com sucesso!');
    }
}
