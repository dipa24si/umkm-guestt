<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\UlasanProduk;
use App\Models\Warga;
use Illuminate\Http\Request;

class UlasanProdukController extends Controller
{
    /**
     * Tampilkan semua ulasan
     */
    public function index()
    {
        $ulasan = UlasanProduk::with(['produk', 'warga'])->get();
        return view('pages.ulasan.index', compact('ulasan'));
    }

    public function create()
    {
        $produk_id = Produk::all();
        $warga_id  = Warga::all();
        return view('pages.ulasan.create', compact('produk_id', 'warga_id'));
    }
    /**
     * Simpan ulasan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produk_id' => 'required|integer',
            'warga_id'  => 'required|integer',
            'rating'    => 'required|integer|min:1|max:5',
            'komentar'  => 'required|string',
        ]);

        UlasanProduk::create($validated);

        return redirect()
            ->route('ulasan.index')
            ->with('success', 'Ulasan berhasil ditambahkan!');
    }

    /**
     * Update ulasan
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
        ]);

        $ulasan = UlasanProduk::findOrFail($id);
        $ulasan->update($validated + [
            'produk_id' => $request->produk_id,
            'warga_id'  => $request->warga_id,
        ]);

        // BALIK KE HALAMAN DAFTAR ULASAN
        return redirect()
            ->route('ulasan.index')
            ->with('success', 'Ulasan berhasil diperbarui!');
    }

    /**
     * Hapus ulasan
     */
    public function destroy($id)
    {
        UlasanProduk::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus!');
    }
    public function edit($id)
    {
        $ulasan = UlasanProduk::findOrFail($id);
        $produk = Produk::all();
        $warga  = Warga::all();

        return view('pages.ulasan.edit', compact('ulasan', 'produk', 'warga'));
    }
}
