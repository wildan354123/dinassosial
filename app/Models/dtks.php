<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dtks extends Model
{
    protected $table = 'dtks';

    protected $fillable = [
        'nama_kepala_keluarga',
        'pekerjaan',
        'kepemilikan_rumah',
        'jenis_atap',
        'jenis_dinding',
        'jenis_lantai',
        'sumber_penerangan',
        'daya_listrik',
        'bahan_bakar',
        'sumber_air',
        'fasilitas_bab',
        'cluster_id',
    ];
}