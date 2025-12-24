<?php
namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Produk;
use App\Models\UlasanProduk;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UlasanProdukController extends Controller
{
    // ============================
    // LIST ULASAN
    // ============================
    public function index()
    {
        $ulasan = UlasanProduk::with(['produk', 'warga'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.ulasan.index', compact('ulasan'));
    }

    // ============================
    // FORM TAMBAH ULASAN
    // ============================
    public function create()
    {
        $produk = Produk::all();
        return view('pages.ulasan.create', compact('produk'));
    }

    // ============================
    // SIMPAN ULASAN
    // ============================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produk_id' => ['required', Rule::exists('produk', 'produk_id')],
            'rating'    => 'required|integer|min:1|max:5',
            'komentar'  => 'required|string',
            'files.*'   => 'nullable|image|max:5120',
        ]);

        // 🔥 AMBIL / BUAT DATA WARGA OTOMATIS (TANPA FORBIDDEN)
        $warga = Warga::firstOrCreate(
            ['email' => Auth::user()->email],
            [
                'no_ktp'        => fake()->unique()->numerify('################'),
                'nama'          => Auth::user()->name,
                'email'         => Auth::user()->email,
                'jenis_kelamin' => 'Laki-laki',
                'agama'         => 'Islam',
                'pekerjaan'     => '-',
                'telp'          => '-',
            ]
        );

        $ulasan = UlasanProduk::create([
            'produk_id' => $validated['produk_id'],
            'warga_id'  => $warga->warga_id,
            'rating'    => $validated['rating'],
            'komentar'  => $validated['komentar'],
        ]);

        // UPLOAD FOTO (JIKA ADA)
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                $name = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('media/ulasan_produk', $name, 'public');

                Media::create([
                    'ref_table'  => 'ulasan_produk',
                    'ref_id'     => $ulasan->ulasan_id,
                    'file_name'  => $name,
                    'mime'       => $file->getClientMimeType(),
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('ulasan.index')
            ->with('success', 'Ulasan berhasil ditambahkan!');
    }

    // ============================
    // FORM EDIT ULASAN
    // ============================
    public function edit($id)
    {
        $ulasan = UlasanProduk::with('warga')->findOrFail($id);
        $produk = Produk::all();

        $ulasanMedia = Media::where('ref_table', 'ulasan_produk')
            ->where('ref_id', $ulasan->ulasan_id)
            ->orderBy('sort_order')
            ->get();

        return view('pages.ulasan.edit', compact('ulasan', 'produk', 'ulasanMedia'));
    }

    // ============================
    // UPDATE ULASAN
    // ============================
    public function update(Request $request, $id)
    {
        $ulasan = UlasanProduk::findOrFail($id);

        $request->validate([
            'produk_id' => ['required', Rule::exists('produk', 'produk_id')],
            'rating'    => 'required|integer|min:1|max:5',
            'komentar'  => 'required|string',
        ]);

        $ulasan->update([
            'produk_id' => $request->produk_id,
            'rating'    => $request->rating,
            'komentar'  => $request->komentar,
        ]);

        return redirect()->route('ulasan.index')
            ->with('success', 'Ulasan berhasil diperbarui!');
    }

    // ============================
    // UPLOAD FOTO BARU
    // ============================
    public function uploadFoto(Request $request, $id)
    {
        $ulasan = UlasanProduk::findOrFail($id);

        $request->validate([
            'files.*' => 'image|max:5120',
        ]);

        $currentMaxSort = Media::where('ref_table', 'ulasan_produk')
            ->where('ref_id', $ulasan->ulasan_id)
            ->max('sort_order') ?? 0;

        foreach ($request->file('files', []) as $file) {
            $name = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('media/ulasan_produk', $name, 'public');

            Media::create([
                'ref_table'  => 'ulasan_produk',
                'ref_id'     => $ulasan->ulasan_id,
                'file_name'  => $name,
                'mime'       => $file->getClientMimeType(),
                'sort_order' => ++$currentMaxSort,
            ]);
        }

        return back()->with('success', 'Foto berhasil diupload!');
    }

    // ============================
    // HAPUS ULASAN + FOTO
    // ============================
    public function destroy($id)
    {
        $ulasan = UlasanProduk::findOrFail($id);

        $medias = Media::where('ref_table', 'ulasan_produk')
            ->where('ref_id', $ulasan->ulasan_id)
            ->get();

        foreach ($medias as $m) {
            Storage::disk('public')->delete("media/ulasan_produk/$m->file_name");
            $m->delete();
        }

        $ulasan->delete();

        return redirect()->route('ulasan.index')
            ->with('success', 'Ulasan berhasil dihapus!');
    }

    // ============================
    // HAPUS FOTO SAJA
    // ============================
    public function destroyMedia($mediaId)
    {
        $m = Media::findOrFail($mediaId);

        Storage::disk('public')->delete("media/ulasan_produk/$m->file_name");
        $m->delete();

        return back()->with('success', 'Foto berhasil dihapus');
    }
}
