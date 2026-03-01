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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->float('total')->default(0.0);
            $table->timestamp('date')->nullable();
            $table->boolean('is_confirmed')->default(false);
            $table->foreignId('payeur')->constrained('users')->onDelete('cascade');
            $table->foreignId('receveur')->constrained('users')->onDelete('cascade');
            $table->engine('InnoDB');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
