<?php

use App\Models\User;
use Database\Seeders\RoleSeeder;
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
        (new RoleSeeder())->run();
        User::find(1)->assignRole("super_admin");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
