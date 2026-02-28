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
        Schema::table('depense_user', function (Blueprint $table) {
            $table->float('montant_du')->default(0.0);
            $table->float('montant_paye')->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('depense_user', function (Blueprint $table) {
            $table->dropColumn('montant_du');
            $table->dropColumn('montant_paye');
        });
    }
};
