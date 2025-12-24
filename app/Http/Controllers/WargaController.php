<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterableColumns = ['jenis_kelamin'];
        $searchableColumns = ['nama', 'no_ktp'];

        $warga = Warga::query()
            ->filter($request, $filterableColumns)
            ->search($request->search, $searchableColumns)
            ->paginate(10)
            ->withQueryString();

        return view('pages.warga.index', compact('warga'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.warga.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_ktp'        => 'required|unique:warga,no_ktp|max:20',
            'nama'          => 'required|string|max:100',
            'jenis_kelamin' => 'required',
            'agama'         => 'required|string|max:50',
            'pekerjaan'     => 'required|string|max:100',
            'telp'          => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:100',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('warga', $namaFile, 'public');
            $data['foto'] = 'warga/' . $namaFile;
        }

        Warga::create($data);

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $warga = Warga::findOrFail($id);
        return view('pages.warga.edit', compact('warga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $warga = Warga::findOrFail($id);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {

            // hapus foto lama
            if ($warga->foto && Storage::disk('public')->exists($warga->foto)) {
                Storage::disk('public')->delete($warga->foto);
            }

            $file = $request->file('foto');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('warga', $namaFile, 'public');
            $data['foto'] = 'warga/' . $namaFile;
        }

        $warga->update($data);

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warga = Warga::findOrFail($id);

        if ($warga->foto && Storage::disk('public')->exists($warga->foto)) {
            Storage::disk('public')->delete($warga->foto);
        }

        $warga->delete();

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil dihapus');
    }
}
