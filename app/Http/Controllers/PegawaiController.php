<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('unit_kerja', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Paginate 10 per halaman, jutkan query string agar 'search' bertahan
        $pegawais = $query->orderBy('name')->paginate(10)->withQueryString();
        return view('home.menu.profil-pegawai', compact('pegawais', 'search'));
    }

    /**
     * Simpan akun pegawai baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'nip'       => 'required|string|unique:users,nip',
            'jabatan'   => 'required|string|max:255',
            'unit_kerja'=> 'nullable|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8|confirmed', // Password minimal 8 karakter dan harus dikonfirmasi
        ]);

        User::create([
            'name'      => $data['name'],
            'nip'       => $data['nip'],
            'jabatan'   => $data['jabatan'],
            'unit_kerja'=> $data['unit_kerja'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
        ]);

        return redirect()
            ->route('profil_pegawai')
            ->with('success', 'Akun pegawai berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit pegawai
     */
    public function edit($id)
    {
        $pegawai = User::findOrFail($id);
        return view('home.menu.edit-pegawai', compact('pegawai'));
    }

    /**
     * Update data pegawai
     */
    public function update(Request $request, $id)
    {
        $pegawai = User::findOrFail($id);

        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'nip'       => ['required', 'string', Rule::unique('users')->ignore($id)],
            'jabatan'   => 'required|string|max:255',
            'unit_kerja'=> 'nullable|string|max:255',
            'email'     => ['required', 'email', Rule::unique('users')->ignore($id)],
            'password'  => 'nullable|string|min:8|confirmed', // Password opsional tapi jika diisi minimal 8 karakter
        ]);

        $updateData = [
            'name'      => $data['name'],
            'nip'       => $data['nip'],
            'jabatan'   => $data['jabatan'],
            'unit_kerja'=> $data['unit_kerja'],
            'email'     => $data['email'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $pegawai->update($updateData);

        return redirect()->route('profil_pegawai')
                         ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Hapus akun pegawai
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('profil_pegawai')
                             ->with('success', 'Akun pegawai berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('profil_pegawai')
                             ->with('error', 'Gagal menghapus pegawai: ' . $e->getMessage());
        }
    }
}