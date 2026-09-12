<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // pelapor
            $table->foreignId('post_id')->nullable()->constrained('community_posts')->cascadeOnDelete();
            $table->foreignId('comment_id')->nullable()->constrained('post_comments')->cascadeOnDelete();
            $table->string('reason', 200);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};