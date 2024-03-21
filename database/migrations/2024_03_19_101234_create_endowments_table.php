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
        Schema::create('endowments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id');
            $table->foreignId('client_id');
            $table->foreignId('stand_id');
            $table->foreignId('agreement_of_sale_id');
            $table->foreignId('payment_id')->nullable();
            $table->string('month_year');
            $table->decimal('amount_paid',50,2)->nullable();
            $table->date('date_paid')->nullable();
            $table->boolean('paid_in_full')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endowments');
    }
};
