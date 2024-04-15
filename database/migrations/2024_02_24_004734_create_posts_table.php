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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('thumbnail')->nullable();
            $table->string('title');
            $table->string('excerpt');
            $table->text('content');
            $table->string('slug')->unique();
            $table->string('status')->default('draft');
            $table->string('type')->default('post');
            $table->string("order_number")->default(1);
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId("biro_id")->nullable()->constrained();
            $table->timestamps();
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
