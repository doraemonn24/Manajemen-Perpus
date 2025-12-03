<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    // Form register
    public function create()
    {
        return view('auth.register');
    }

    // Simpan data register
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // Jika ingin batasi email universitas
                function ($attribute, $value, $fail) {
                    if (!preg_match('/@.*\.(ac|edu)\.id$/i', $value)) {
                        $fail('Email harus email universitas (ac.id atau edu.id).');
                    }
                }
            ],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Default role = 'mahasiswa'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa', // default, nanti admin bisa ubah di database
        ]);

        // Login langsung setelah register
        auth()->login($user);

        // Redirect sesuai role di database
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!');
            case 'pegawai':
                return redirect()->route('pegawai.dashboard')->with('success', 'Selamat datang Pegawai!');
            default:
                return redirect()->route('mahasiswa.dashboard')->with('success', 'Selamat datang Mahasiswa!');
        }
    }
}
