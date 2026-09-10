<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The two about-page bands that are lists of copy rather than lists of logos.
 *
 * Partners, clients and certifications all share the `clients` table under a
 * scope because they are the same shape; core values and awards are not, so
 * they get their own tables and their own dashboard screens.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('core_values', function (Blueprint $table) {
            $table->id();
            // shown in the circle badge; a string so "01" keeps its zero
            $table->string('number', 10)->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('year', 20)->nullable();
            $table->string('awarded_by')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('awards');
        Schema::dropIfExists('core_values');
    }
};
