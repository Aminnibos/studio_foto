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
    Schema::create('pembayarans', function (Blueprint $table) {
        $table->id();
        $table->string('kode_booking')->unique();
        $table->string('nama_pelanggan');
        $table->string('email_pelanggan');
        $table->string('no_hp');
        $table->string('paket');
        $table->string('durasi')->nullable();
        $table->dateTime('tanggal_booking');
        $table->integer('total_pembayaran');
        $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
        $table->string('bukti_pembayaran')->nullable(); // menyimpan path foto struk bank
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
