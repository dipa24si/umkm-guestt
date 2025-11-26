<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan daftar user (CRUD)
     */
    public function index()
    {
        $users = User::all();
        return view('pages.user.login', compact('users')); // ini halaman manajemen user, BUKAN login
    }

    /**
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        return view('guest.login.login'); // ini view form login kamu
    }

    /**
     * Proses login user (PAKAI Auth::attempt)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // penting

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Login berhasil!');
        }

        // gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout user (PAKAI Auth::logout)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }

    /**
     * Tampilkan form register
     */
    public function showRegisterForm()
    {
        return view('pages.user.register');
    }

    /**
     * Proses register user baru
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Simpan user baru (password HARUS di-hash)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // optional: langsung login
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil!');
    }

    // ===== CRUD USER LAINNYA =====

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('guest.users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
