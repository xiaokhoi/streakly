<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('streak_graves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('length');      // seberapa panjang streak yang mati
            $table->date('died_at');                 // kapan hangusnya
            $table->string('cause')->default('bolong'); // bolong | hangus
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('streak_graves');
    }
};