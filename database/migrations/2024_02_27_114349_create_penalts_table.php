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
        Schema::create('penalts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id');
            $table->foreignId('client_id');
            $table->foreignId('stand_id')->nullable();
            $table->foreignId('agreement_of_sale_id')->nullable();
            $table->decimal('percentage',30,2);
            $table->date('date_generated')->nullable();
            $table->decimal('amount_charged',30,2);
            $table->string('generated_for_month');
            $table->string('generated_for_year');
            $table->decimal('amount_paid',30,2)->nullable();
            $table->foreignId('payment_id')->nullable();
            $table->date('date_of_payment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penalts');
    }
};
