<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('rps_counts', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('ip');
            $table->string('type');
            $table->float('speed')->nullable();
            $table->integer('status_code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rps_counts');
    }
};