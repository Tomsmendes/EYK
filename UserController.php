<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Funcao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $data['users'] = User::join('funcaos', 'users.fc_id', '=', 'funcaos.id')
            ->select(
                'users.*',
                'funcaos.name_fc as f_nome'
            )->get();

        $data['funcoes'] = Funcao::all();

        return view('admin.users.index', $data);
    }
    
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        $data['funcoes'] = Funcao::all();

        return view('auth.register', $data);
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

        $filePath = public_path('Uploads');
        $insert = new User();
        $insert->name = $request->name;
        $insert->email = $request->email;
        $insert->fc_id = $request->fc_id;
        $insert->password = bcrypt($request->password);

        if ($request->hasfile('photo')) {
            $file = $request->file('photo');
            $file_name = time() . $file->getClientOriginalName();
            $file->move($filePath, $file_name);
            $insert->photo = $file_name;
        }

        $insert->save();

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }

    public function update(Request $request, User $user)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
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
            if ($user->photo && file_exists(public_path('Uploads/' . $user->photo))) {
                unlink(public_path('Uploads/' . $user->photo));
            }

            $file = $request->file('photo');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('Uploads'), $file_name);
            $data['photo'] = $file_name;
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}