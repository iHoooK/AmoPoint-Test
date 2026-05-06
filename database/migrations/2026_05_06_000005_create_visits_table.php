<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->uuid('client_id')->index();
            $table->string('site_key');
            $table->text('page_url');
            $table->string('page_host')->nullable()->index();
            $table->text('referrer')->nullable();
            $table->string('ip', 45)->nullable()->index();
            $table->string('country')->nullable();
            $table->string('city')->nullable()->index();
            $table->string('device_type')->nullable();
            $table->string('browser')->nullable();
            $table->string('platform')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('language')->nullable();
            $table->unsignedSmallInteger('screen_width')->nullable();
            $table->unsignedSmallInteger('screen_height')->nullable();
            $table->string('timezone')->nullable();
            $table->timestamp('visited_at')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
