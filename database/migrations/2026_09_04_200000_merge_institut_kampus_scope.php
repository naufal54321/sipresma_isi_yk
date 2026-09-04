<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $kampusId = DB::table('activity_scopes')->where('name', 'Kampus')->first()->id;
        $institutId = DB::table('activity_scopes')->where('name', 'Institut')->first()->id;

        if ($kampusId && $institutId) {
            DB::table('point_rules')->where('scope_id', $institutId)->update(['scope_id' => $kampusId]);
            DB::table('activity_scopes')->where('id', $institutId)->delete();
        }

        DB::table('activity_scopes')->where('name', 'Kampus')->update(['name' => 'Institut/Kampus']);
    }

    public function down(): void
    {
        DB::table('activity_scopes')->where('name', 'Institut/Kampus')->update(['name' => 'Kampus']);
        DB::table('activity_scopes')->insert(['name' => 'Institut', 'code' => 'I', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()]);
    }
};
