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
    Schema::create('rpks', function (Blueprint $table) {

        $table->id();

        $table->foreignId('user_id')
            ->constrained()
            ->onDelete('cascade');

        $table->string('tahun');

        $table->enum('semester', [
            'Ganjil',
            'Genap'
        ]);

        $table->enum('kategori', [
            'Individu',
            'Kelompok'
        ]);

        $table->timestamps();
    });
}


    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rpks');
    }

    
};
