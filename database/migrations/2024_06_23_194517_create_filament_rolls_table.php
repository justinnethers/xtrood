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
        Schema::create('filament_rolls', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Filament::class);
            $table->foreignIdFor(\App\Models\User::class);
            $table->integer('weight')->default(1000);
            $table->string('size')->default('1kg');
            $table->string('diameter')->default('1.75mm');
            $table->decimal('price')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filament_rolls');
    }
};
