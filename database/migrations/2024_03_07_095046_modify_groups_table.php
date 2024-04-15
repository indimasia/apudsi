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
        Schema::table('groups', function (Blueprint $table) {
            $table->string("image")->nullable(true)->change();
            $table->timestamp("meet_time")->nullable();
            $table->string("meet_location");
            $table->dropColumn("descriptions");
            $table->text("note");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->string("image")->nullable(false)->change();
            $table->dropColumn("meet_time");
            $table->dropColumn("meet_location");
            $table->text("descriptions");
            $table->dropColumn("note");
        });
    }
};
