<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])->get();
        return response()->json(['data' => $peminjamans], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id',
            'id_buku' => 'required|exists:buku,id',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'nullable|date',
            'status_peminjaman' => 'required|in:dipinjam,dikembalikan',
        ]);

        $peminjaman = Peminjaman::create($request->all());

        return response()->json(['data' => $peminjaman], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])->find($id);

        if (!$peminjaman) {
            return response()->json(['message' => 'Peminjaman not found'], 404);
        }

        return response()->json(['data' => $peminjaman], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            return response()->json(['message' => 'Peminjaman not found'], 404);
        }

        $request->validate([
            'id_anggota' => 'required|exists:anggota,id',
            'id_buku' => 'required|exists:buku,id',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'nullable|date',
            'status_peminjaman' => 'required|in:dipinjam,dikembalikan',
        ]);

        $peminjaman->update($request->all());

        return response()->json(['data' => $peminjaman], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            return response()->json(['message' => 'Peminjaman not found'], 404);
        }

        $peminjaman->delete();

        return response()->json(['message' => 'Peminjaman deleted successfully'], 200);
    }
}
