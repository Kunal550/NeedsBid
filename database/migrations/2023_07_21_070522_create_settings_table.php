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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('meta_title');
            $table->text('meta_keyword');
            $table->longText('meta_description');
            $table->string('site_name');
            $table->string('logo');
            $table->string('site_mail');
            $table->string('contact_no');
            $table->longText('site_address');
            $table->longText('footer_text');
            $table->string('insta_link');
            $table->string('linkdin_link');
            $table->string('fb_link');
            $table->string('twitter_link');
            $table->string('smtp_host');
            $table->string('smtp_port');
            $table->string('smtp_name');
            $table->string('smtp_username');
            $table->string('smtp_pwd');
            $table->string('smtp_form_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
