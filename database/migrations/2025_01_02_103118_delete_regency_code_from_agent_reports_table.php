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
        Schema::table('agent_reports', function (Blueprint $table) {
            $table->dropColumn('regency_code');
            $table->char('city_code', 5)->nullable()->index()->after('province_code');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agent_reports', function (Blueprint $table) {
            $table->char('regency_code', 5)->nullable()->index()->after('province_code');
            $table->dropColumn('city_code');
        });
    }
};

