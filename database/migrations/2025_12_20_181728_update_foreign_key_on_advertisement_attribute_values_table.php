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
        Schema::table('advertisement_attribute_values', function (Blueprint $table) {
            $table->dropForeign(['advertisement_id']);
            $table->foreign('advertisement_id')
                ->references('id')->on('advertisements')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('advertisement_attribute_values', function (Blueprint $table) {
            $table->dropForeign(['advertisement_id']);
            $table->foreign('advertisement_id')
                ->references('id')->on('advertisements');
        });
    }
};
