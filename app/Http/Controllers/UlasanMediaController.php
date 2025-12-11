<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\UlasanProduk; // ganti jika model ulasan punya nama lain
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UlasanMediaController extends Controller
{
    // Upload multiple media for a ulasan
    public function upload(Request $request, $ulasanId)
    {
        $request->validate([
            'files'   => 'required|array',
            'files.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // validate ulasan exists
        $ulasan = UlasanProduk::findOrFail($ulasanId);

        $ref_table = 'ulasan_produk';
        $saved = [];

        DB::beginTransaction();
        try {
            foreach ($request->file('files') as $file) {
                $orig = $file->getClientOriginalName();
                $mime = $file->getClientMimeType();
                $safeName = time() . '_' . Str::random(6) . '_' . preg_replace('/\s+/', '_', $orig);

                // simpan file
                $file->storeAs("public/media/{$ref_table}", $safeName);

                // hitung sort order
                $maxSort = Media::where('ref_table', $ref_table)
                                ->where('ref_id', $ulasanId)
                                ->max('sort_order');
                $sortOrder = $maxSort ? $maxSort + 1 : 1;

                $m = Media::create([
                    'ref_table' => $ref_table,
                    'ref_id'    => $ulasanId,
                    'file_name' => $safeName,
                    'caption'   => null,
                    'mime_type' => $mime,
                    'sort_order'=> $sortOrder,
                ]);

                $saved[] = $m;
            }
            DB::commit();

            // response JSON for AJAX or redirect back
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => true, 'media' => $saved], 201);
            }
            return back()->with('success', 'File berhasil diupload.');
        } catch (\Exception $e) {
            DB::rollBack();
            // cleanup files saved
            foreach ($saved as $s) {
                Storage::delete("public/media/{$ref_table}/{$s->file_name}");
            }
            return back()->withErrors('Upload gagal: ' . $e->getMessage());
        }
    }

    // Delete media by id
    public function destroy($mediaId)
    {
        $m = Media::findOrFail($mediaId);
        $path = "public/media/{$m->ref_table}/{$m->file_name}";
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
        $m->delete();
        return response()->json(['success' => true]);
    }

    // Optional: update caption/sort
    public function update(Request $request, $mediaId)
    {
        $m = Media::findOrFail($mediaId);
        $m->update($request->only(['caption','sort_order']));
        return response()->json(['success' => true, 'media' => $m]);
    }
}
