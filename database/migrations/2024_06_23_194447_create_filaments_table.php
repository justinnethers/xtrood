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
        Schema::create('filaments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Brand::class);
            $table->foreignIdFor(\App\Models\FilamentType::class);
            $table->foreignIdFor(\App\Models\Color::class);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filaments');
    }
};
