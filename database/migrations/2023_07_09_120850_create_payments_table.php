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
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->integer('month');
            $table->integer('year');
            $table->integer('point')->nullable();
            $table->integer('hours')->nullable();
            $table->integer('rate')->nullable();
            $table->integer('base')->nullable();
            $table->integer('travel')->nullable();
            $table->integer('bonus')->nullable();
            $table->integer('withdraw')->nullable();
            $table->integer('absence')->default(0);
            $table->integer('absence_cut')->nullable();
            $table->integer('salary')->nullable();
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
