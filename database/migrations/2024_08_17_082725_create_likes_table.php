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
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->uuid('global_id')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('blog_id')->nullable()->constrained('blogs')->onDelete('set null');
            $table->foreignId('destination_id')->nullable()->constrained('destinations')->onDelete('set null');
            $table->foreignId('review_id')->nullable()->constrained('reviews')->onDelete('set null');
            $table->foreignId('comment_id')->nullable()->constrained('comments')->onDelete('set null');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
