<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Artisan::call('make:filament-user', [
            '--name' => 'Admin',
            '--email' => 'admin@gmail.com',
            '--password' => '12345678',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
