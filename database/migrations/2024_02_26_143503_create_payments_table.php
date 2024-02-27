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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->foreignId('client_id')->constrained();
            $table->foreignId('stand_id')->nullable()->constrained();
            $table->foreignId('invoice_id')->nullable();
            $table->string('receipt_number')->nullable();
            $table->date('receipt_date');
            $table->decimal('amount_paid',30,2);
            $table->string('description');
            $table->string('payment_method')->default('cash');
            $table->string('currency');
            $table->mediumText('amount_in_words')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
