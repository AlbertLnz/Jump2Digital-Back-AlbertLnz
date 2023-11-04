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
        Schema::create('skins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('types');
            $table->smallInteger('price');
            $table->string('color', 255)->collation('utf8mb4_unicode_ci');
            $table->string('category');
            $table->string('design_pattern');
            $table->string('rarity');
            $table->boolean('bought')->default(false);
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
