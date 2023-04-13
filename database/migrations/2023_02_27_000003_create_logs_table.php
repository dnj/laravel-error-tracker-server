<?php

use dnj\AAA\Models\User;
use dnj\ErrorTracker\Contracts\LogLevel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('error_tracker_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('app_id')
                ->constrained('error_tracker_apps', 'id')
                ->cascadeOnDelete();

            $table->foreignId('device_id')
                ->constrained('error_tracker_devices', 'id')
                ->cascadeOnDelete();

            $table->foreignId('reader_id')
                ->nullable()
                ->constrained((new User())->getTable(), 'id')
                ->cascadeOnDelete();

            $table->timestamp('read_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
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
