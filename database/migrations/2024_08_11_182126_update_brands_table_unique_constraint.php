<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            // Remove the existing unique constraint on the name column
            $table->dropUnique(['name']);

            // Add a new composite unique constraint
            $table->unique(['name', 'type']);
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            // Remove the composite unique constraint
            $table->dropUnique(['name', 'type']);

            // Re-add the unique constraint to the name column
            $table->unique('name');
        });
    }
};
