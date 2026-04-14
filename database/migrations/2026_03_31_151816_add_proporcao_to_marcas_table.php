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
            // float é ideal para guardar números como 0.5, 1.2, etc.
            $table->float('proporcao')->nullable()->after('qtd_tracos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marcas', function (Blueprint $table) {
            $table->dropColumn('proporcao');
        });
    }
};
