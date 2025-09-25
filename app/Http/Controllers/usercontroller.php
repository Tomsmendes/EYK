<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Funcao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('Site.Pages.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'vc_nome' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
                'photo' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            ]);

            $userData = $request->except('photo');
            $userData['password'] = Hash::make($request->password);

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('Uploads'), $fileName);
                $userData['photo'] = $fileName;
            }

            User::create($userData);

            return redirect()->route('user.all')->with('success', 'Usuário criado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar usuário: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Erro ao criar usuário: ' . $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'vc_nome' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|min:6|confirmed',
                'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            ]);

            $userData = $request->only(['vc_nome', 'email']);

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('photo')) {
                if ($user->photo && file_exists(public_path('Uploads/' . $user->photo))) {
                    @unlink(public_path('Uploads/' . $user->photo));
                }

                $file = $request->file('photo');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('Uploads'), $fileName);
                $userData['photo'] = $fileName;
            }

            $user->update($userData);

            return redirect()->route('user.all')->with('success', 'Usuário atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar usuário: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Erro ao atualizar usuário: ' . $e->getMessage()])->withInput();
        }
    }
    
    public function delete($id)
    {
        $users = User::where('id',$id)->first();
        $users->delete();

        return redirect()->route('users.all')->with('success', 'Usuário excluído com sucesso!');
    }
}