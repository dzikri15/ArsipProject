<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * AuthController - Menangani autentikasi pengguna
 * TODO: Integrasikan dengan tabel users di database
 */
class AuthController extends Controller
{
    /**
     * Demo users (untuk saat ini tanpa database)
     * @var array
     */
    private array $users = [
        ['id' => 1, 'email' => 'dzikri@ukri.ac.id',  'password' => 'password', 'role' => 'admin', 'name' => 'M. Dzikri Sagara',  'nim' => '20241320004', 'initial' => 'DS'],
        ['id' => 2, 'email' => 'jilan@ukri.ac.id',   'password' => 'password', 'role' => 'user',  'name' => 'Jilan Jalilah',      'nim' => '20241320039', 'initial' => 'JJ'],
        ['id' => 3, 'email' => 'nosa@ukri.ac.id',    'password' => 'password', 'role' => 'user',  'name' => 'Nosa Putra',         'nim' => '20241320025', 'initial' => 'NP'],
        ['id' => 4, 'email' => 'sahrul@ukri.ac.id',  'password' => 'password', 'role' => 'user',  'name' => 'Ahmad Sahrul P',     'nim' => '20241320031', 'initial' => 'AS'],
        ['id' => 5, 'email' => 'eka@ukri.ac.id',     'password' => 'password', 'role' => 'user',  'name' => 'Eka Pebryanto',      'nim' => '20241320014', 'initial' => 'EP'],
    ];

    /**
     * Tampilkan halaman login
     * @return \Illuminate\View\View
     */
    public function showLogin()
    {
        if (session('user')) {
            return redirect()->route('dashboard');
        }
        return view('pages.login');
    }

    /**
     * Proses login pengguna
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        // TODO: Ganti dengan query ke database
        foreach ($this->users as $user) {
            if ($user['email'] === $request->email && $user['password'] === $request->password) {
                session(['user' => $user]);
                return redirect()->route('dashboard')->with('success', 'Login berhasil!');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    /**
     * Proses logout pengguna
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}
