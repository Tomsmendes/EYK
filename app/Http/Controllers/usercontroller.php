<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Exibe a lista de usuários
    public function index()
    {
        $users = User::all();
        
        return view('admin.student.user.index', compact('users'));
    }

    public function indexp()
    {
        $users = User::all();
        
        return view('admin.teacher.user.index', compact('users'));
    }


    public function indexc()
    {
        $users = User::all();
        return view('admin.student.chat.index', compact('users'));
    }

    public function indext()
    {
        $users = User::all();
        return view('admin.student.text.index', compact('users'));
    }

    public function indexa()
    {
        $users = User::all();
        return view('admin.student.aJuda.index', compact('users'));
    }

    public function indexe()
    {
        $users = User::all();
        return view('admin.student.edt.index', compact('users'));
    }

    public function indexav()
    {
        $users = User::all();
        return view('admin.student.avaliar.index', compact('users'));
    }

    public function indexh()
    {
        $users = User::all();
        return view('admin.student.hist.index', compact('users'));
    }

    // Exibe o formulário de registro
    public function indexRegister()
    {
        return view('auth.register');
    }

    // Processa o registro de um novo usuário
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'in:student,teacher', // Validação do campo role
        ]);
        

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Hash será feito no modelo
            'role' => $request->role ?? 'student', // Definir o papel
        ]);

        Auth::login($user);
        
        if ($user->role == 'student') {
            return redirect()->route('admin.student.user.index')->with('success', 'Login realizado com sucesso Bem Vindo');
        } else {
            return redirect()->route('admin.teacher.user.index')->with('success', 'Login realizado com sucesso Bem Vindo');
        }
        
    }

    // Exibe o formulário de login
    public function indexLogin()
    {
        return view('auth.login');
    }

    // Processa o login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        // Verificar se o email existe
        $user = User::where('email', $credentials['email'])->first();
    
        if (!$user) {
            return back()->withErrors([
                'email' => 'O email fornecido não foi encontrado.',
            ])->onlyInput('email');
        }
    
        // Verificar se a senha está correta
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'password' => 'A senha fornecida está incorreta.',
            ])->onlyInput('password');
        }
    
        // Autenticar o usuário se ambos estiverem corretos
        Auth::login($user);
        $request->session()->regenerate();
        
        if ($user->role == 'student') {
            return redirect()->route('admin.student.user.index')->with('success', 'Login realizado com sucesso Bem Vindo' );
        }
        else{
            return redirect()->route('admin.teacher.user.index')->with('success', 'Login realizado com sucesso Bem Vindo' );
        }
    }
    

    // Processa o logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Logout realizado com sucesso!');
    }
}
