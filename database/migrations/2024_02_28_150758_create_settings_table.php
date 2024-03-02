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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id');
            $table->string('company_name');
            $table->mediumText('address');
            $table->string('email');
            $table->string('logo')->default('/images/logo.png');
            $table->string('vendor_number')->nullable();
            $table->string('bpn_number')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('landline_1')->nullable();
            $table->string('landline_2')->nullable();
            $table->string('mobile_1')->nullable();
            $table->string('mobile_2')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
