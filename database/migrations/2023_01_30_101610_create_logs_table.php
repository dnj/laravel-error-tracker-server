<?php

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
            $table->integer('app_id');

            $table->foreign('app_id')
                ->references('id')
                ->on('apps')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('device_id');

            $table->foreign('device_id')
                ->references('id')
                ->on('devices')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->dateTime('read_at')->nullable();
            $table->enum('level', ['DEBUG',
                'INFO',
                'WARN',
                'ERROR',
                'FATAL', ]);
            $table->string('message');
            $table->string('date')->nullable();
            $table->timestamps();
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
