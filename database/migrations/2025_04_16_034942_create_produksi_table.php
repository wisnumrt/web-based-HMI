<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produksi', function (Blueprint $table) {
            $table->id('id_produksi');
            $table->foreignId('id')->constrained('data_pekerjaan')->onDelete('cascade');
            $table->time('durasi_pre');
            $table->time('durasi_run');
            $table->integer('realisasi');
            $table->integer('waste');
            $table->time('durasi_trouble');
            $table->string('j_trouble');
            $table->time('durasi_break');
            $table->string('j_breakdown');
            $table->string('plate');
            $table->string('kertas');
            $table->string('tinta');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksi');
    }
};
