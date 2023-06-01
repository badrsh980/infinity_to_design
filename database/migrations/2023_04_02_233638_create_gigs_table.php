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
        Schema::create('gigs', function (Blueprint $table) {
            $table->id();

            $table->string('status', 250)->comment('pending - active - inactive')->default('pending');
            $table->string('title', 250);
            $table->string('slug', 250)->unique();
            $table->longText('description');
            $table->longText('thumbnails');
            $table->integer('delivery_time')->nullable();
            $table->longText('instructions')->nullable();
            $table->float('price')->nullable();

            $table->longText('user_changes')->nullable();
            $table->string('language', 2)->default('ar');

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gigs');
    }
};
