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
       Schema::table('taxpayers', function (Blueprint $table) {
            $table->string('password')->nullable()->after('name');
            $table->boolean('status')->default(true); // adds a boolean 'status' column with default false
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('taxpayers', function (Blueprint $table) {
            $table->dropColumn(['password', 'remember_token','status']);
        });

    }
};
