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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('assessment_id');

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->unsignedInteger('asset_id');
            $table->unsignedInteger('taxpayer_id');
            $table->unsignedInteger('profile_id');

            $table->string('assessment_ref_no', 50);
            $table->dateTime('assessment_date');
            $table->decimal('assessment_amount', 10, 2)->default(0.00);

            // Settlement Information
            $table->date('settlement_due_date');
            $table->unsignedInteger('settlement_status_id');
            $table->string('settlement_status_name', 50);
            $table->date('settlement_date')->nullable();
            $table->text('assessment_notes')->nullable();

            $table->unsignedInteger('assessment_rule_id');
            $table->string('assessment_rule_code', 20);
            $table->string('assessment_rule_name', 100);
            $table->decimal('assessment_rule_amount', 10, 2)->default(0.00);

            $table->unsignedInteger('assessment_item_id');
            $table->string('assessment_item_reference_no', 20);
            $table->string('assessment_item_name', 100);
            $table->decimal('tax_base_amount', 10, 2)->default(0.00);
            $table->decimal('percentage', 5, 2)->default(5.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
