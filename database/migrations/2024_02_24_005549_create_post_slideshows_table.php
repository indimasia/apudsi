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
        Schema::create('post_slideshows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained();
            $table->string('title')->nullable();
            $table->string('attachment');
            $table->string('caption')->nullable();
            $table->string('order_number')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_slideshows');
    }
};
