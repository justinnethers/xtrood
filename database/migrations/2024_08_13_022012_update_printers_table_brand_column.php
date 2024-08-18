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
        Schema::table('printers', function (Blueprint $table) {
            // Remove the existing unique constraint on the name column
            $table->dropColumn(['brand']);
            $table->dropColumn(['model']);
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('printers', function (Blueprint $table) {
            // Remove the existing unique constraint on the name column
            $table->dropColumn(['brand_id']);
            $table->string('brand');
            $table->string('model');
        });
    }
};
