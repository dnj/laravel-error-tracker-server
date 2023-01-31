<?php

use dnj\ErrorTracker\Laravel\Server\Constants\LogLevelConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_id');
            $table->unsignedBigInteger('device_id');
            $table->enum('level', [LogLevelConstants::$statuses]);
            $table->text('message');
            $table->json('data')->nullable();
            $table->boolean('read')->nullable();
            $table->timestamps();

            $table->foreign('app_id')->references('id')->on('apps');
            $table->foreign('device_id')->references('id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
