<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('filament_roll_user_printer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filament_roll_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_printer_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('filament_roll_user_printer');
    }
};
