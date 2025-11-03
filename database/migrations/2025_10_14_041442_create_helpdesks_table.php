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
        Schema::create('helpdesks', function (Blueprint $table) {
            $table->id();
            $table->string('helpdesk_user_name');
            $table->string('helpdesk_user_email');
            $table->string('helpdesk_user_phone')->nullable();
            $table->integer('helpdesk_kategori');
            $table->text('helpdesk_subjek_aduan');
            $table->longText('helpdesk_butiran_aduan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helpdesks');
    }
};
