<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::first();

        return view('Admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nominal_dp' => 'required|integer|min:0',

            'jam_buka' => 'required',

            'jam_tutup' => 'required',

            'whatsapp' => 'nullable|string|max:30',

            'email' => 'nullable|email',

            'alamat' => 'nullable',

            'maps' => 'nullable',

            'instagram' => 'nullable|string|max:255',

            'tiktok' => 'nullable|string|max:255',
        ]);

        Setting::first()->update($data);

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}