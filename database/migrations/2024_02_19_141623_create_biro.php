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
        Schema::create('biros', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string("code")->unique();
            $table->string('description')->nullable();
            $table->string('owner')->nullable();
            $table->string('marketing_phone')->nullable();
            $table->string("logo")->nullable();
            $table->string("address")->nullable();
            $table->char("province_code", 2)->nullable()->index();
            $table->char("city_code", 5)->nullable()->index();
            $table->integer("average_person_per_year")->default(0);
            $table->boolean("is_active")->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biros');
    }
};
