<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wilayah', function (Blueprint $table) {
            $table->string("kode");
            $table->string("nama")->nullable();
        });

        DB::statement("CREATE VIEW provinces AS SELECT * FROM wilayah WHERE LENGTH(kode) = 2");
        DB::statement("CREATE VIEW cities AS SELECT kode, LEFT(kode,2) as kode_provinsi, nama FROM wilayah WHERE LENGTH(kode) = 5");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayah');
        DB::statement("DROP VIEW provinces");
        DB::statement("DROP VIEW cities");
    }
};
