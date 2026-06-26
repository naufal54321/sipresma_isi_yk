<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKegiatanUserTable extends Migration
{
    public function up()
    {
        Schema::create('kegiatan_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            // Hindari duplikasi
            $table->unique(['kegiatan_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kegiatan_user');
    }
}