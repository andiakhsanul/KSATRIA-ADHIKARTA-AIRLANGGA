<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('Auth.login');
    }
    public function authenticate(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!Auth::attempt($data)) {
            return redirect()->back()->with('error', 'Email doesnt match in our database');
        }

        return redirect('dashboard');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
