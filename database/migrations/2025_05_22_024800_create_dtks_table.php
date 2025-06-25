<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dtks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kepala_keluarga');
            $table->integer('pekerjaan');
            $table->integer('kepemilikan_rumah');
            $table->integer('jenis_atap');
            $table->integer('jenis_dinding');
            $table->integer('jenis_lantai');
            $table->integer('sumber_penerangan');
            $table->integer('daya_listrik');
            $table->integer('bahan_bakar');
            $table->integer('sumber_air');
            $table->integer('fasilitas_bab');
    
            $table->timestamps();
        });
    }
};
