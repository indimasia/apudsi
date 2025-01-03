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
        Schema::create('share_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('title', 191);
            $table->string('image', 191);
            $table->string('link', 191)->nullable()->default(null);
            $table->text('caption');
            $table->string('status', 191)->nullable()->default(null);
            $table->timestamps();
            $table->string('description', 191)->nullable()->default(null);
            $table->integer('share_counter')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('share_contents');
    }
};
