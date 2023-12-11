<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
    ];

    static public function getBuku()
    {
     $return = DB::table('Buku')
     ->join('kategori', 'buku.id_kategori', '=', 'kategori.id');
        return $return;
    }
}
