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
        Schema::create('content_models', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('content_image');
            $table->string('button_name');
            $table->string('button_link');
            $table->longText('short_desc')->nullable();
            $table->longText('description')->nullable();
            $table->enum('status',['A','I','D'])->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_models');
    }
};
