<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
        });

        // backfill: user lama dapet username dari nama mereka (slug + anti-dobel)
        foreach (DB::table('users')->get() as $u) {
            $base = Str::slug($u->name) ?: 'user' . $u->id;
            $username = $base;
            $i = 1;

            while (DB::table('users')->where('username', $username)->where('id', '!=', $u->id)->exists()) {
                $username = $base . $i++;
            }

            DB::table('users')->where('id', $u->id)->update(['username' => $username]);
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};