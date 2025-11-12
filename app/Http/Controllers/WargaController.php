<?php

namespace App\Http\Controllers;
use App\Models\Warga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warga = Warga::all();
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
        // Validasi data
        $request->validate([
            'no_ktp' => 'required|unique:warga,no_ktp|max:20',
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:100',
            'telp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        // Simpan ke database
        Warga::create($request->all());

        // Redirect kembali ke halaman daftar warga
        return redirect()->route('warga.index')->with('success', 'Data warga berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $warga->update($request->all());
        return redirect()->route('warga.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warga = Warga::findOrFail($id);
        $warga->delete();
        return redirect()->route('warga.index')->with('success', 'Warga dihapus!');
    }
}
