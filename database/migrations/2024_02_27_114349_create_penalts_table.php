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
            $table->foreignId('project_id')->constrained();
            $table->foreignId('client_id')->constrained();
            $table->foreignId('stand_id')->nullable()->constrained();
            $table->foreignId('payment_id')->nullable()->constrained();
            $table->decimal('percentage',3,2);
            $table->decimal('amount_paid',30,2);
            $table->date('date_of_default')->nullable();
            $table->date('date_generated')->nullable();
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
