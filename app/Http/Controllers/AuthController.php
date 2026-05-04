<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Galeri;
use App\Models\Pengaduan;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nik' => 'nullable|string|max:16',
            'no_telepon' => 'nullable|string|max:16',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'is_admin' => 0, 
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek Role
            if (Auth::user()->is_admin) {
                // Admin diarahkan ke URL /admin/halamanutama
                return redirect()->intended('/admin/halamanutama');
            }
            
            // Pengguna biasa tetap di halaman utama
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function adminDashboard()
    {
        // Mengambil data asli dari Database
        $totalPengaduan = \App\Models\Pengaduan::count();
        
        // PERBAIKAN DI SINI:
        // Mencari status 'Pending' (atau sesuaikan jika di db huruf kecil semua 'pending')
        $pengaduanPending = \App\Models\Pengaduan::where('status_pengaduan', 'Pending')->count();
        
        $totalGaleri = \App\Models\Galeri::count();
        $totalUser = \App\Models\User::count();
        $totalAnggota = \App\Models\Anggota::count();

        // Mengirim variabel ke view resources/views/admin/halamanutama.blade.php
        return view('admin.halamanutama', compact(
            'totalPengaduan', 
            'pengaduanPending', 
            'totalGaleri', 
            'totalUser',
            'totalAnggota'
        ));
    }

    // =========================================================================
    // --- FITUR KELOLA USER (TAMBAHAN UNTUK ADMIN) ---
    // =========================================================================

    public function indexUser()
    {
        $users = User::all();
        return view('admin.kelola_user.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.kelola_user.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'is_admin' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'is_admin' => $request->is_admin,
        ]);

        return redirect()->route('admin.kelola-user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser(User $user)
    {
        return view('admin.kelola_user.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'is_admin' => $request->is_admin,
        ];

        // Hanya update password jika diisi di form
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.kelola-user.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.kelola-user.index')->with('success', 'User berhasil dihapus.');
    }
}