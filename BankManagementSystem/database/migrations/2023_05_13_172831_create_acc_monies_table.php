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
        Schema::create('acc_monies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('acc_id')->constrained('accounts')->cascadeOnDelete();
            $table->foreignId('money_id')->constrained('monies')->cascadeOnDelete();
            $table->double('balance')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_monies');
    }
};
