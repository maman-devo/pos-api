<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            // Mengubah kolom 'type' dari ENUM menjadi STRING
            $table->string('type')->change();
        });
    }

    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            // Mengembalikan kolom 'type' ke tipe ENUM sebelumnya jika rollback
            $table->enum('type', ['percentage'])->default('percentage')->change();
        });
    }
};