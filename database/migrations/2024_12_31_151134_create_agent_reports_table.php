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
        Schema::create('agent_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location');
            $table->string('lng');
            $table->string('lat');
            $table->string('image');
            $table->text('description')->nullable();
            $table->char('province_code', 2)->nullable()->index();
            $table->char('regency_code', 5)->nullable()->index();
            $table->char('district_code', 8)->nullable()->index();
            $table->char('village_code', 13)->nullable()->index();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('agent_id')->constrained('agents');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_reports');
    }
};
