<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('status', 250)->comment('pending - active - inactive')->default('pending');
            $table->string('username', 250)->unique();
            $table->string('email', 250)->unique();
            $table->string('password', 250);
            $table->string('name', 250)->nullable();
            $table->string('address', 250)->nullable();
            $table->string('state', 250)->nullable();
            $table->string('city', 250)->nullable();
            $table->string('post_code', 250)->nullable();
            $table->string('country', 250)->nullable();
            $table->string('thumbnail', 250)->nullable();
            $table->longText('description')->nullable();
            $table->time('last_seen')->nullable();
            $table->string('response_time', 250)->default('1 day');
            $table->double('balance')->default(0);
            $table->string('withdrawal_email', 250)->nullable();
            $table->string('withdrawal_method', 250)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->string('token', 250)->unique();
            $table->string('specialization', 250)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
