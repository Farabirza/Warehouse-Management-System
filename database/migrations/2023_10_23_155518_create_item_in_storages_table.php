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
        Schema::create('item_in_storages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('count')->default(0);
            $table->foreignUuid('item_id');
            $table->foreignUuid('storage_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_in_storages');
    }
};
