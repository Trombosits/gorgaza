<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Handle Register
public function register(Request $request)
{
    // 1. Tentukan daftar domain email yang Anda izinkan di sini
    // Anda bisa menambah atau mengurangi daftar ini sesuai kebutuhan
    $allowedDomains = '@gmail.com,@yahoo.com,@outlook.com,@upi.edu,@hotmail.com,@proton.me';

    $validated = $request->validate([
        'nama' => 'required|string|max:100',
        'no_hp' => 'required|string|max:20',
        'email' => [
            'required',
            'email',
            'unique:users,email',
            'ends_with:' . $allowedDomains // Memastikan email berakhiran dengan domain di atas
        ],
        'password' => 'required|string|min:6',
    ], [
        // Kustomisasi pesan error jika domain tidak sesuai
        'email.ends_with' => 'Registrasi gagal. Hanya domain email (Gmail, Yahoo, Outlook, UPI, Hotmail, Proton) yang diizinkan!',
        'email.unique' => 'Email ini sudah terdaftar.',
        'email.email' => 'Format email tidak valid.'
    ]);

    User::create([
        'nama' => $validated['nama'],
        'no_hp' => $validated['no_hp'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']), // Enkripsi password
        'created_at' => now()
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Registrasi berhasil! Silakan login.'
    ], 201);
}

    // Handle Login
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $validated['email'])->first();

        // Validasi keberadaan user dan kecocokan password
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah!'
            ], 401);
        }

        // Kembalikan data user agar bisa disimpan di localStorage oleh JavaScript
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil!',
            'user' => [
                'id' => $user->id,
                'name' => $user->nama,
                'email' => $user->email,
                'phone' => $user->no_hp
            ]
        ]);
    }
}