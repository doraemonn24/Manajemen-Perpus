<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:users,email',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->role === 'mahasiswa' && !preg_match('/@.*\.ac\.id$/i', $value)) {
                        $fail('Email Mahasiswa harus email universitas (@ac.id).');
                    }
                }
            ],
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,pegawai,mahasiswa',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $user->id,
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->role === 'mahasiswa' && !preg_match('/@.*\.ac\.id$/i', $value)) {
                        $fail('Email Mahasiswa harus email universitas (@ac.id).');
                    }
                }
            ],
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,pegawai,mahasiswa',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
}
