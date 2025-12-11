<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Warga;
use App\Models\UlasanProduk;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UlasanProdukController extends Controller
{
    // ============================
    // LIST
    // ============================
    public function index(Request $request)
    {
        $ulasan = UlasanProduk::with(['produk', 'warga'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.ulasan.index', compact('ulasan'));
    }

    // ============================
    // CREATE FORM
    // ============================
    public function create()
    {
        $produk_id = Produk::all();
        $warga_id  = Warga::all();
        return view('pages.ulasan.create', compact('produk_id', 'warga_id'));
    }

    // ============================
    // STORE ULASAN + FILE BARU
    // ============================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produk_id' => ['required','integer', Rule::exists('produk','produk_id')],
            'warga_id'  => ['required','integer', Rule::exists('warga','warga_id')],
            'rating'    => 'required|integer|min:1|max:5',
            'komentar'  => 'required|string',
            'files.*'   => 'nullable|image|max:5120'
        ]);

        $ulasan = UlasanProduk::create([
            'produk_id' => $validated['produk_id'],
            'warga_id'  => $validated['warga_id'],
            'rating'    => $validated['rating'],
            'komentar'  => $validated['komentar'],
        ]);

        // Upload foto
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {

                $name = Str::random(20).'.'.$file->getClientOriginalExtension();

                $file->storeAs('media/ulasan_produk', $name, 'public');

                Media::create([
                    'ref_table' => 'ulasan_produk',
                    'ref_id'    => $ulasan->ulasan_id,
                    'file_name' => $name,
                    'mime'      => $file->getClientMimeType(),
                    'sort_order'=> $index,
                ]);
            }
        }

        return redirect()->route('ulasan.index')->with('success','Ulasan berhasil ditambahkan!');
    }

    // ============================
    // EDIT FORM
    // ============================
    public function edit($id)
    {
        $ulasan = UlasanProduk::findOrFail($id);
        $produk_id = Produk::all();
        $warga = Warga::all();

        $ulasanMedia = Media::where('ref_table','ulasan_produk')
            ->where('ref_id',$ulasan->ulasan_id)
            ->orderBy('sort_order','asc')
            ->get();

        return view('pages.ulasan.edit', compact('ulasan','produk_id','warga','ulasanMedia'));
    }

    // ============================
    // UPDATE ULASAN (TIDAK WAJIB UPLOAD FOTO BARU)
    // ============================
    public function update(Request $request, $id)
    {
        $ulasan = UlasanProduk::findOrFail($id);

        $validated = $request->validate([
            'produk_id' => ['required','integer', Rule::exists('produk','produk_id')],
            'warga_id'  => ['required','integer', Rule::exists('warga','warga_id')],
            'rating'    => 'required|integer|min:1|max:5',
            'komentar'  => 'required|string',
        ]);

        $ulasan->update($validated);

        return redirect()->route('ulasan.index')->with('success','Ulasan berhasil diperbarui!');
    }

    // ============================
    // METODE UPLOAD FOTO BARU (KHUSUS)
    // ============================
    public function uploadFoto(Request $request, $id)
    {
        $ulasan = UlasanProduk::findOrFail($id);

        $request->validate([
            'files.*' => 'image|max:5120'
        ]);

        $currentMaxSort = Media::where('ref_table','ulasan_produk')
            ->where('ref_id',$ulasan->ulasan_id)
            ->max('sort_order');

        $currentMaxSort = $currentMaxSort === null ? 0 : $currentMaxSort + 1;

        foreach ($request->file('files', []) as $file) {

            $name = Str::random(20).'.'.$file->getClientOriginalExtension();

            $file->storeAs('media/ulasan_produk', $name, 'public');

            Media::create([
                'ref_table' => 'ulasan_produk',
                'ref_id'    => $ulasan->ulasan_id,
                'file_name' => $name,
                'mime'      => $file->getClientMimeType(),
                'sort_order'=> $currentMaxSort++,
            ]);
        }

        return back()->with('success','Foto baru berhasil diupload!');
    }

    // ============================
    // DELETE ULASAN + FOTO
    // ============================
    public function destroy($id)
    {
        $ulasan = UlasanProduk::findOrFail($id);

        $medias = Media::where('ref_table','ulasan_produk')
            ->where('ref_id',$ulasan->ulasan_id)
            ->get();

        foreach ($medias as $m) {
            if (Storage::disk('public')->exists("media/ulasan_produk/$m->file_name")) {
                Storage::disk('public')->delete("media/ulasan_produk/$m->file_name");
            }
            $m->delete();
        }

        $ulasan->delete();

        return redirect()->route('ulasan.index')->with('success','Ulasan berhasil dihapus!');
    }

    // ============================
    // DELETE FOTO SAJA
    // ============================
    public function destroyMedia($mediaId)
    {
        $m = Media::findOrFail($mediaId);

        if (Storage::disk('public')->exists("media/ulasan_produk/$m->file_name")) {
            Storage::disk('public')->delete("media/ulasan_produk/$m->file_name");
        }

        $m->delete();

        return back()->with('success','Foto berhasil dihapus');
    }
}
