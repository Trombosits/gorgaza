<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $allowedDomains = '@gmail.com,@yahoo.com,@outlook.com,@upi.edu,@hotmail.com,@proton.me';

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'email' => [
                'required',
                'email',
                'unique:users,email',
                'ends_with:' . $allowedDomains,
            ],
            'password' => 'required|string|min:6',
        ], [
            'email.ends_with' => 'Registrasi gagal. Hanya domain email Gmail, Yahoo, Outlook, UPI, Hotmail, atau Proton yang diizinkan!',
            'email.unique' => 'Email ini sudah terdaftar.',
            'email.email' => 'Format email tidak valid.',
        ]);

        User::create([
            'name' => $validated['nama'],
            'nama' => $validated['nama'],
            'no_hp' => $validated['no_hp'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil! Silakan login.',
        ], 201);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah!',
            ], 401);
        }

        $authUser = [
            'id' => $user->id,
            'name' => $user->nama ?? $user->name,
            'email' => $user->email,
            'phone' => $user->no_hp,
            'role' => $user->role ?? 'customer',
        ];

        session()->put('auth_user', $authUser);

        $redirect = $authUser['role'] === 'admin'
            ? '/admin/dashboard'
            : session()->pull('intended_url', '/');

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil!',
            'redirect' => $redirect,
            'user' => $authUser,
        ]);
    }

    public function logout(Request $request)
    {
        session()->forget('auth_user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout berhasil.');
    }
}
