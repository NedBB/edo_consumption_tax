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
        // Schema::create('taxpayers', function (Blueprint $table) {
        //     $table->id();

        //     $table->unsignedInteger('taxpayer_id');

        //     $table->unsignedBigInteger('category_id');
        //     $table->foreign('category_id')
        //         ->references('id')
        //         ->on('categories')
        //         ->onDelete('cascade');

        //     $table->string('typeid');
        //     $table->string('typename')->nullable();
        //     $table->string('name')->nullable();
        //     $table->string('rin')->nullable();
        //     $table->string('phone', 20)->nullable();
        //     $table->text('address')->nullable();
        //     $table->string('email', 100)->nullable();
        //     $table->string('tin', 20)->nullable();
        //     $table->string('tax_office', 100)->nullable();
        //     $table->timestamps();
        // });
        Schema::create('taxpayers', function (Blueprint $table) {
            $table->id();

            // Add nullable user_id foreign key
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');  // Set to null if user is deleted

            $table->unsignedInteger('taxpayer_id');

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->string('typeid');
            $table->string('typename')->nullable();
            $table->string('name')->nullable();
            $table->string('rin')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('email', 100)->nullable();
            $table->string('tin', 20)->nullable();
            $table->string('tax_office', 100)->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxpayers');
    }
};
