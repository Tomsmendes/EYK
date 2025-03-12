<?php

namespace App\Http\Controllers;

use App\Models\Funcao;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function index()
    {
        //$data['users'] = User::all();

        $data['users'] = User::join('funcaos', 'users.fc_id', '=', 'funcaos.id')->
        select(
            'users.*',
            'funcaos.name_fc as f_nome'
        )->get();

        
        return view('admin.users.index', $data);
    }

    public function create()
    {
        $data ['funcaos'] = funcao::all();

        return view('admin.users.create', $data); 
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'fc_id' => 'required',
            'photo' => 'mimes:png,jpg,jpeg|max:2048' 
        ]);
    
        $filePath = public_path('uploads');
        $insert = new User();
        $insert -> name = $request->name;
        $insert -> email = $request->email;
        $insert -> fc_id = $request->fc_id;
        $insert -> password = bcrypt('password');

        if ($request->hasfile('photo')){
            $file = $request->file('photo');
            $file_name = time() . $file->getClientOriginalName();

            $file->move($filePath, $file_name);
            $insert->photo =$file_name;
        }

        $result = $insert->save();

        //Session::flash('Success', 'User registred successfully');
        return redirect()->route('users.index');
    }
    

    public function edit($id)
    {
        $users = User::where('id',$id)->first();
        $funcaos = funcao::all();
        
        if(!empty($users))
        {
            return view('admin.users.edit', compact('users', 'funcaos'));
        }
        else
        {
            return redirect()->route('users.index');
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); 
    
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id, 
            'password' => 'nullable|min:6', 
            'fc_id' => 'required',
            'photo' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);
    
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'fc_id' => $request->fc_id,
        ];
    
        if (!empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        }
    
        if ($request->hasFile('photo')) {
            if ($user->photo && file_exists(public_path($user->photo))) {
                unlink(public_path($user->photo));
            }
    
            $file = $request->file('photo');
            $file_name = time() . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $file_name);
            $data['photo'] = $file_name;
        }
    
        $user->update($data);
    
        return redirect()->route('users.index');
    } 


    public function destroy($id)
    {
        $users = User::where('id',$id)->first();
        $users->delete();

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }

}