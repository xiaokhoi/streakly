<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();      // yang ngirim permintaan
            $table->foreignId('friend_id')->constrained('users')->cascadeOnDelete();   // yang nerima -> PENTING: eksplisit ke users!
            $table->string('status')->default('pending');                        // pending | accepted
            $table->string('type')->default('sahabat');                          // sahabat | pacar | keluarga | gym
            $table->unsignedInteger('streak_count')->default(0);                 // streak bareng
            $table->date('last_mutual_date')->nullable();                        // terakhir dua-duanya check-in
            $table->timestamps();

            $table->unique(['user_id', 'friend_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('friendships');
    }
};