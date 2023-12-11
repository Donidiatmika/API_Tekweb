<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bukus = buku::all();
        return response()->json([
            'data' =>$bukus
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'jumlah_halaman' => 'required|integer',
        
        ]);

        try {
            $response = Buku::create($validasi);

            return response()->json([
                'success' => true,
                'message' => 'success',
                'data' => $response,
            ]);

        } catch (\Throwable $th) {
        
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $th->getMessage(),
            ]);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak tersedia'], 404);
        }

        return response()->json(['data' => $buku], 200);
    }

    public function update(Request $request, string $id)
    {
        $buku = Buku::find($id);
    
        if (!$buku) {
            return response()->json(['message' => 'Buku tidak tersedia'], 404);
        }
    
        $request->validate([
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'jumlah_halaman' => 'required|integer',
        
        ]);
    
        $buku->update($request->all());
    
        return response()->json(['data' => $buku], 200);
    }
    

    public function destroy(string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak tersedia'], 404);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku dberhasil dihapus'], 200);
    }
}

