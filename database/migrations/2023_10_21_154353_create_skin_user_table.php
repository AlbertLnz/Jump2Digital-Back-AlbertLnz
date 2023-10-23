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
        Schema::create('skin_user', function (Blueprint $table) {
            $table->id();
            
            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('skin_id')->nullable();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('skin_id')->references('id')->on('skins')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skins');
    }
};
