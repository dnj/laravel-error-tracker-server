<?php

use dnj\AAA\Models\User;
use dnj\ErrorTracker\Contracts\LogLevel;
use dnj\ErrorTracker\Laravel\Server\Models\App;
use dnj\ErrorTracker\Laravel\Server\Models\Device;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('error_tracker_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(App::class, 'app_id')
                ->references('id')
                ->cascadeOnDelete();

            $table->foreignIdFor(Device::class, 'device_id')
                ->references('id')
                ->cascadeOnDelete();

            $table->foreignIdFor(User::class, 'reader_id')
                ->nullable()
                ->references('id')
                ->cascadeOnDelete();

            $table->timestamp('read_at')->nullable();
            $table->timestamp('created_at');
            $table->enum('level', array_column(LogLevel::cases(), 'name'));
            $table->string('message');
            $table->json('data')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('error_tracker_logs');
    }
};
