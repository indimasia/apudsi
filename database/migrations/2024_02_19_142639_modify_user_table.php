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
            $table->string("email")->nullable()->change();
            $table->string('phone')->nullable();
            $table->char('gender', 1)->nullable();
            $table->foreignId("biro_id")->nullable()->constrained();
            $table->char("province_code", 2)->nullable()->index();
            $table->char('city_code', 5)->nullable()->index();
            $table->boolean("is_active")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("email")->nullable(false)->change();
            $table->dropColumn('phone');
            $table->dropColumn('gender');
            $table->dropForeign(['biro_id']);
            $table->dropColumn('biro_id');
            $table->dropIndex(['province_code']);
            $table->dropColumn('province_code');
            $table->dropIndex(['city_code']);
            $table->dropColumn('city_code');
            $table->dropColumn('is_active');
        });
    }
};
