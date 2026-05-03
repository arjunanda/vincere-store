<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Traits\DashboardHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    use DashboardHelpers;

    public function index()
    {
        $user = auth()->user();
        return view('dashboard.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'whatsapp' => 'nullable|string|max:20',
        ]);

        $user->update($data);

        $this->logActivity('UPDATE_PROFILE', "Memperbarui informasi profil");

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function security()
    {
        return view('dashboard.profile.security');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        $this->logActivity('UPDATE_PASSWORD', "Memperbarui kata sandi akun");

        return back()->with('success', 'Kata sandi berhasil diubah!');
    }
}
