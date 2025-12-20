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
        Schema::create('advertisement_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertisement_id')
                ->constrained('advertisements')
                ->cascadeOnDelete();
            $table->foreignId('attribute_id')->constrained('attributes');
            $table->string('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisement_attribute_values');
    }
};
