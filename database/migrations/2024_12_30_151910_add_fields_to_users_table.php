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
        Schema::table('users', function (Blueprint $table) {
            $table->char('district_code', 8)->nullable()->index()->after('city_code');
            $table->char('village_code', 13)->nullable()->index()->after('district_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['district_code']);
            $table->dropColumn('district_code');
            $table->dropIndex(['village_code']);
            $table->dropColumn('village_code');
        });
    }
};
