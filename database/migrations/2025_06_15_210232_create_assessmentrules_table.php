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
        Schema::create('assessmentrules', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('assessment_rule_id');

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

           $table->unsignedInteger('asset_id');
            $table->unsignedInteger('taxpayer_id');
            $table->unsignedInteger('profile_id');

            $table->string('assessment_rule_code', 20);
            $table->string('assessment_rule_name', 100);

            $table->unsignedInteger('rule_run_id');
            $table->string('rule_run_name', 50);

            $table->unsignedInteger('payment_frequency_id');
            $table->string('payment_frequency_name', 50);
            $table->unsignedInteger('payment_option_id');
            $table->string('payment_option_name', 50);

            $table->decimal('assessment_amount', 10, 2)->default(0.00);
            $table->unsignedSmallInteger('tax_year');
            $table->unsignedTinyInteger('tax_month')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessmentrules');
    }
};
