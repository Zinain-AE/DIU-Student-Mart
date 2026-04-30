<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function showLogin()
    {
        return view('auth.login');
    }

    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            
            if (isset($user->is_active) && !$user->is_active) {
                Auth::logout();
                return back()->with('error', 'Your account is deactivated. Contact Admin.');
            }


            return redirect()->intended('/')->with('success', 'Welcome back, ' . $user->name . '!');
        }

       
        return back()->with('error', 'Invalid email or password.')->onlyInput('email');
    }

    
    public function showRegister()
    {
        return view('auth.register');
    }

   
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
           
            'email'      => [
                'required', 
                'email', 
                'unique:users', 
                'regex:/^[a-zA-Z0-9._%+-]+@diu\.edu\.bd$/i'
            ],
            'student_id' => 'nullable|string|unique:users',
            'department' => 'required|string',
            'semester'   => 'nullable|string',
            'batch'      => 'nullable|string',
            'role'       => 'required|in:student,teacher',
            'password'   => 'required|min:6|confirmed',
        ], [
            
            'email.regex' => 'Registration is only for DIU Students (@diu.edu.bd only).'
        ]);

        
        $data['password'] = Hash::make($data['password']);
        
        
        $user = User::create($data);

        
        Auth::login($user);

        return redirect('/')->with('success', 'Registration successful! Welcome to the Mart.');
    }

    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'You have been logged out.');
    }
}