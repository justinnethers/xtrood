<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('filament_usages', function (Blueprint $table) {
            $table->foreignId('user_printer_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('filament_usages', function (Blueprint $table) {
            $table->dropForeign(['user_printer_id']);
            $table->dropColumn('user_printer_id');
        });
    }
};
