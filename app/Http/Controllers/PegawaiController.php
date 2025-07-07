<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    /**
     * Tampilkan halaman profil pegawai dengan form dan tabel
     * Data di-paginate 10 per halaman
     */
    public function index(Request $request)
    {
         $search = $request->input('search');

        $query = User::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        // Paginate 10 per halaman, jutkan query string agar 'search' bertahan
        $pegawais = $query->paginate(10)->withQueryString();
       return view('home.menu.profil-pegawai', compact('pegawais', 'search'));
    }

    /**
     * Simpan akun pegawai baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email',
            'password'=> 'required|string|min:6',
        ]);

        // Buat user baru
        User::create([
            'name'     => $data['name'],
            'jabatan'  => $data['jabatan'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()
            ->route('profil_pegawai')
            ->with('success', 'Akun pegawai berhasil ditambahkan.');
    }
    public function destroy(User $user)
{
    $user->delete();
    return redirect()->route('profil_pegawai')
                     ->with('success', 'Akun pegawai berhasil dihapus.');
}
}