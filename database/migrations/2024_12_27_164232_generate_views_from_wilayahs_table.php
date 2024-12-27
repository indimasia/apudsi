<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE VIEW provinces AS SELECT * FROM wilayah WHERE LENGTH(kode) = 2");
        DB::statement("CREATE VIEW cities AS SELECT kode, LEFT(kode,2) as kode_provinsi, nama FROM wilayah WHERE LENGTH(kode) = 5");
        DB::statement("CREATE VIEW districts AS SELECT kode, LEFT(kode,2) as kode_provinsi, LEFT(kode,5) as kode_kota, nama FROM wilayah WHERE LENGTH(kode) = 8");
        DB::statement("CREATE VIEW villages AS SELECT kode, LEFT(kode,2) as kode_provinsi, LEFT(kode,5) as kode_kota, LEFT(kode,8) as kode_kecamatan, nama FROM wilayah WHERE LENGTH(kode) = 13");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW provinces");
        DB::statement("DROP VIEW cities");
        DB::statement("DROP VIEW districts");
        DB::statement("DROP VIEW villages");
    }
};
