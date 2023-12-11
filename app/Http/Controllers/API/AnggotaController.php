<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anggota;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggotas = Anggota::all();
        return response()->json(['data' => $anggotas], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_anggota' => 'required',
            'alamat_anggota' => 'required',
            'email_anggota' => 'required|email|unique:anggota,email_anggota',
            'tanggal_registrasi' => 'nullable|date',
        ]);

        $anggota = Anggota::create($request->all());

        return response()->json(['data' => $anggota], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $anggota = Anggota::find($id);

        if (!$anggota) {
            return response()->json(['message' => 'Anggota not found'], 404);
        }

        return response()->json(['data' => $anggota], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $anggota = Anggota::find($id);

        if (!$anggota) {
            return response()->json(['message' => 'Anggota not found'], 404);
        }

        $request->validate([
            'nama_anggota' => 'required',
            'alamat_anggota' => 'required',
            'email_anggota' => 'required|email|unique:anggota,email_anggota,' . $id,
            'tanggal_registrasi' => 'nullable|date',
        ]);

        $anggota->update($request->all());

        return response()->json(['data' => $anggota], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anggota = Anggota::find($id);

        if (!$anggota) {
            return response()->json(['message' => 'Anggota not found'], 404);
        }

        $anggota->delete();

        return response()->json(['message' => 'Anggota deleted successfully'], 200);
    }
}
