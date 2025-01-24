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
        Schema::table('wilayah', function (Blueprint $table) {
            $table->string("kode")->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->string('nama')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wilayah', function (Blueprint $table) {
            $table->string("kode")->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->string('nama')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
        });
    }
};
