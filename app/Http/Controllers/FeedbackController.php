<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;
        $user = $userId ? User::find($userId) : null;

        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu untuk mengirim kritik dan saran.');
        }

        $data = $request->validate([
            'pesan' => 'required|string|min:5|max:1000',
        ]);

        Feedback::create([
            'user_id' => $user->id,
            'nama' => $user->nama ?? $user->name ?? 'Pelanggan',
            'email' => $user->email,
            'pesan' => $data['pesan'],
            'is_read' => false,
        ]);

        return redirect('/#kritik-saran')->with('success', 'Terima kasih. Kritik dan saran kamu sudah terkirim ke admin GOR GAZA.');
    }
}
