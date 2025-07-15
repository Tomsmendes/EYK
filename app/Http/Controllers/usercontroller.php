<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Funcao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data['users'] = User::join('funcaos', 'users.fc_id', '=', 'funcaos.id')
            ->select('users.*', 'users.fc_id', 'funcaos.name_fc as f_nome') // 🔧 incluído fc_id
            ->get();

        $data['funcoes'] = Funcao::all();

        return view('Site.Pages.users.index', $data);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'vc_nome' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
                'fc_id' => 'required|exists:funcaos,id',
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
                'fc_id' => 'required|exists:funcaos,id',
                'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            ]);

            $userData = $request->only(['vc_nome', 'email', 'fc_id']);

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
            return back()->withErrors(['error' => 'Erro ao atualizar usuário: ' . $e->getMessage()])->withInput();
        }
    }

    public function delete(User $user)
    {
        try {
            if (!empty($user->photo) && file_exists(public_path('Uploads/' . $user->photo))) {
                @unlink(public_path('Uploads/' . $user->photo));
            }

            $user->delete();

            return redirect()->route('user.all')->with('success', 'Usuário excluído com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao excluir usuário: ' . $e->getMessage()]);
        }
    }
}
