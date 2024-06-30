<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('pelanggan')->nullable(); // Menggunakan unsignedBigInteger untuk foreign key
            $table->foreign('pelanggan')->references('id')->on('pelanggan'); // Mengubah id_user menjadi id sebagai foreign key
            $table->string('progress');
            $table->string('waktu');
            $table->string('catatan');
            $table->string('tugas');
            $table->unsignedBigInteger('karyawan1')->nullable(); // Menggunakan unsignedBigInteger untuk foreign key
            $table->foreign('karyawan1')->references('id')->on('users'); // Mengubah id_user menjadi id sebagai foreign key
            $table->unsignedBigInteger('karyawan2')->nullable(); // Menggunakan unsignedBigInteger untuk foreign key
            $table->foreign('karyawan2')->references('id')->on('users'); // Mengubah id_user menjadi id sebagai foreign key
            $table->unsignedBigInteger('karyawan3')->nullable(); // Menggunakan unsignedBigInteger untuk foreign key
            $table->foreign('karyawan3')->references('id')->on('users'); // Mengubah id_user menjadi id sebagai foreign key
            $table->unsignedBigInteger('karyawan4')->nullable(); // Menggunakan unsignedBigInteger untuk foreign key
            $table->foreign('karyawan4')->references('id')->on('users'); // Mengubah id_user menjadi id sebagai foreign key
            $table->unsignedBigInteger('karyawan5')->nullable(); // Menggunakan unsignedBigInteger untuk foreign key
            $table->foreign('karyawan5')->references('id')->on('users'); // Mengubah id_user menjadi id sebagai foreign key
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal');
    }
};
