<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    protected function create(array $data)
    {
        return User::create([
            'Name' => $data['name'],
            'Email' => $data['email'],
            'password' => Hash::make($data['password']),
            'Role' => $data['role'],
            'image' =>'user.png',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:Admin,Nhan_Vien'],
            
        ]);
        $user = $this->create($validated);

        event(new Registered($user));

        return redirect()->route('tai-khoan.index');
    }
}
