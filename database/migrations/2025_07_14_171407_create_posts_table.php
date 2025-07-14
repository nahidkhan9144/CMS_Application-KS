<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    
//     CREATE TABLE posts (
//     id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     title VARCHAR(255) NOT NULL,
//     slug VARCHAR(255) NOT NULL UNIQUE,
//     content TEXT NOT NULL,
//     summary TEXT,
//     status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
//     published_date TIMESTAMP NULL DEFAULT NULL,
//     author_id BIGINT UNSIGNED NOT NULL,
//     created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
//     updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//     FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
// );

    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->text('summary')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_date')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->timestamps();

            // Foreign key constraint (optional)
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
