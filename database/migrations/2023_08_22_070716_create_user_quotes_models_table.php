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
        Schema::create('user_quotes_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('post_code');
            $table->string('project_time_scale');
            $table->longText('additional_details')->nullable();
            $table->string('kitchen_plan');
            $table->json('worktops');
            $table->json('splashback');
            $table->json('upstand');
            $table->json('windowsill');
            $table->decimal('worktops_final_price',10,2);
            $table->decimal('splashback_final_price',10,2);
            $table->decimal('upstand_final_price',10,2);
            $table->decimal('windowsill_final_price',10,2);
            $table->enum('status',['A','I','D'])->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_quotes_models');
    }
};
