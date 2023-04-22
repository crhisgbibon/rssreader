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
        Schema::create('rss_table_sources', function (Blueprint $table) {
            $table->id('uniqueIndex')->autoIncrement();

            $table->integer('userID');

            $table->string('sourceTitle', 255);
            $table->string('sourceLink', 1000);
            $table->string('groupName', 255);
            $table->string('category', 255);
            $table->string('country', 255);

            $table->integer('updated_at');

            $table->tinyInteger('hiddenRow');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rss_table_sources');
    }
};
