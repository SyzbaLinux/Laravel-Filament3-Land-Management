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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id');
            $table->foreignId('client_id');
            $table->foreignId('stand_id');
            $table->foreignId('agreement_of_sale_id');
            $table->foreignId('payment_id')->nullable();
            $table->string('month');
            $table->string('year');
            $table->boolean('processed')->default(0);


            $table->decimal('balance_bf',50,2)->nullable();
            $table->decimal('balance',50,2)->nullable();
            $table->float('amount')->nullable();
            $table->boolean('is_paid_infull')->nullable();



            $table->float('penalty')->nullable(); //amount charged
            $table->float('penalty_paid_amount')->nullable(); //amount charged
            $table->foreignId('penalty_payment_id')->nullable(); //amount charged
            $table->boolean('is_penalty_paid_infull')->nullable();
            $table->date('date_penalty_paid')->nullable();




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
