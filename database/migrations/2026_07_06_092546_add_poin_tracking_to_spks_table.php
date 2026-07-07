<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPoinTrackingToSpksTable extends Migration
{
    public function up()
    {
        Schema::table('spks', function (Blueprint $table) {
            if (!Schema::hasColumn('spks', 'poin_added_at')) {
                $table->timestamp('poin_added_at')->nullable()->after('poin');
            }
            if (!Schema::hasColumn('spks', 'poin_added_by')) {
                $table->unsignedBigInteger('poin_added_by')->nullable()->after('poin_added_at');
                $table->foreign('poin_added_by')
                      ->references('id')
                      ->on('users')
                      ->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('spks', function (Blueprint $table) {
            $table->dropForeign(['poin_added_by']);
            $table->dropColumn(['poin_added_at', 'poin_added_by']);
        });
    }
}