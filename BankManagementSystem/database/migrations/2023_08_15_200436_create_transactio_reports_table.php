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
        Schema::create('transactio_reports', function (Blueprint $table) {
            $table->id();
            $table->string('FromCustomer')->nullable();
            $table->string('ToCustomer')->nullable();
            $table->string('AccountNumberFrom')->nullable();
            $table->string('AccountNumberTo')->nullable();
            $table->date('trans_date')->default(now());
            $table->double('balance');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactio_reports');
    }
};
