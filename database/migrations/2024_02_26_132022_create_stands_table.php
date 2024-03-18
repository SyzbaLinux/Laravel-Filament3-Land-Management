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
        Schema::create('stands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable();
            $table->foreignId('invoice_id')->nullable();
            $table->foreignId('agreement_of_sale_id')->nullable();
            $table->foreignId('project_id');
            $table->string('stand_number')->nullable();
            $table->string('square_metres')->nullable();
            $table->decimal('price',20,2)->nullable();
            $table->decimal('electrification_costs',20,2)->nullable();
            $table->mediumText('description')->nullable();
            $table->date('listing_date')->nullable();
            $table->boolean('is_taken')->default(0);
            $table->boolean('custom_price')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stands');
    }
};
