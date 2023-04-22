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
        Schema::create('rss_table_categories', function (Blueprint $table) {
          $table->id('uniqueIndex')->autoIncrement();

          $table->integer('userID');

          $table->string('cagtegory', 255);

          $table->tinyInteger('hiddenRow');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rss_table_categories');
    }
};
