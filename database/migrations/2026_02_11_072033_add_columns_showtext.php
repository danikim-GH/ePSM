<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table(
            'carousels',
            function (Blueprint $table) {
            // Show / Hide title + caption
            $table->boolean('show_text')
                  ->default(true)
                  ->after('description');

            // Overlay opacity (0.00 - 1.00)
            $table->decimal('overlay_opacity', 3, 2)
                  ->default(0.50)
                  ->after('show_text');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
