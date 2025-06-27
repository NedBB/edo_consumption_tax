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
        Schema::create('assessmentdatas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('taxpayer_type_id');
            $table->unsignedInteger('taxpayer_id');
            $table->text('notes')->nullable();
            $table->unsignedInteger('asset_type_id');
            $table->unsignedInteger('asset_id');
            $table->unsignedInteger('profile_id');
            $table->string('reference_code');
            $table->string('status')->default('pending');
            $table->unsignedInteger('assessment_rule_id');
            $table->unsignedInteger('tax_year');
            $table->decimal('tax_amount', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessmentdatas');
    }
};
