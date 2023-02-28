<?php

use dnj\AAA\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('error_tracker_devices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('meta')->nullable();
            $table->foreignIdFor(User::class, 'owner_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('error_tracker_devices');
    }
};
