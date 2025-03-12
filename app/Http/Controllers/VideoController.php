<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class Videocontroller extends Controller
{
    public function index()
    {
        $data['videos'] = Video::all();

        /*$data['users'] = User::join('funcaos', 'users.funcao_id', '=', 'funcaos.id')->
        select(
            'users.*',
            'funcaos.fc_name as f_nome'
        )->get();*/

        
        return view('admin.videos.index', $data);
    }

    public function create()
    {
        $data['users'] = Video::all();

        return view('admin.videos.create', $data); 
    }


    public function store(Request $request)
    {
       Video::create($request->all());

       return redirect()->route('videos.index');
    }

    public function edit($id)
    {
        $videos = Video::where('id',$id)->first();
        
        if(!empty($videos))
        {
            return view('admin.videos.edit', compact('videos'));
        }
        else
        {
            return redirect()->route('videos.index');
        }
    }

    public function update(Request $request, $id)
    {
        $data = [
            'vd_name' => $request->vd_name,
            'url' => $request->url,
            'vd_descricao' => $request->vd_descricao,
        ];
        Video::where('id',$id)->update($data);

        return redirect()->route('videos.index');
    }

    public function destroy($id)
    {
        $users = Video::where('id',$id)->first();
        $users->delete();

        return redirect()->route('videos.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
