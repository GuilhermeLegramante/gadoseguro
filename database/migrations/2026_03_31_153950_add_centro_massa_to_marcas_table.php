<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('marcas', function (Blueprint $table) {
            // Guardamos o centro de massa relativo (0.0 a 1.0)
            $table->float('centro_x')->nullable()->after('proporcao');
            $table->float('centro_y')->nullable()->after('centro_x');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marcas', function (Blueprint $table) {
            $table->dropColumn(['centro_x', 'centro_y']);
        });
    }
};
