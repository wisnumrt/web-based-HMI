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
        Schema::create('data_pekerjaan', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('id_mesin')->constrained('mesin')->onDelete('cascade');
            $table->string('nomor_spk');
            $table->string('produk');
            $table->time('w_start');
            $table->time('w_finish');
            $table->string('quantity');
            // $table->integer('durasi_plan')->nullable();
            // $table->integer('quantity_plan')->nullable();
            // $table->integer('pre_setting')->nullable();


            // $table->integer('durasi_running')->nullable();
            // $table->integer('quantity_running')->nullable();
            // $table->integer('waste')->nullable();

            // $table->integer('durasi_trouble')->nullable();
            // $table->string('jenis_trouble')->nullable();

            // // Breakdown
            // $table->integer('durasi_break_down')->nullable();
            // $table->string('jenis_break_down')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pekerjaan');
    }
};
