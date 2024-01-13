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
        Schema::table('instruments', function (Blueprint $table) {
            $table->foreignId('category_id')
            ->default(1)
            ->constrained()
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instruments', function (Blueprint $table) {
            $table->dropForeign(['intstruments_category_id']);
            $table->dropColumn('instruments_category_id');
        });
    }
};
