<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title',100);
            $table->string('slug',150)->unique();
            $table->foreignId('category_id')->constrained('blog_categories')->cascadeOnDelete();
            $table->foreignId('operator_id')->constrained('users')->cascadeOnDelete();
            $table->text('description');
            $table->string('thumbnail',100);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('blogs');
    }
    
};
