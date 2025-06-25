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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('asset_id');
            $table->unsignedInteger('taxpayer_id');

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->unsignedInteger('asset_type_id');
            $table->string('asset_type_name', 50);
            $table->unsignedInteger('business_type_id');
            $table->string('business_type_name', 50);
            $table->string('business_rin', 20);
            $table->string('business_name', 100);
            $table->unsignedInteger('lga_id');
            $table->string('lga_name', 50);
            $table->unsignedInteger('business_category_id');
            $table->string('business_category_name', 50);
            $table->unsignedInteger('business_sector_id');
            $table->string('business_sector_name', 100);
            $table->unsignedInteger('business_sub_sector_id');
            $table->string('business_sub_sector_name', 100);
            $table->unsignedInteger('business_structure_id');
            $table->string('business_structure_name', 50);
            $table->unsignedInteger('business_operation_id');
            $table->string('business_operation_name', 50);
            $table->unsignedInteger('size_id');
            $table->string('size_name', 50);
            $table->string('contact_name', 100);
            $table->string('business_number', 20);
            $table->text('business_address');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
