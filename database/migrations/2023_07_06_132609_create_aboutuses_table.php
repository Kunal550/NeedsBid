<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aboutuses', function (Blueprint $table) {
            $table->id();
            $table->string('page_heading');
            $table->longText('content');
            $table->string('image');
            $table->enum('type', ['aboutus', 'mission', 'vission', 'faq'])->default('faq');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aboutuses');
    }
};
