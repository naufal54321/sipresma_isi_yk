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
    Schema::table('rpks', function (Blueprint $table) {

        $table->foreignId('master_kegiatan_id')
              ->nullable()
              ->after('user_id')
              ->constrained('master_kegiatans')
              ->cascadeOnDelete();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rpks', function (Blueprint $table) {
            //
        });
    }
};
