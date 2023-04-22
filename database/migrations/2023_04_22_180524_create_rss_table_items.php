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
        Schema::create('rss_table_items', function (Blueprint $table) {
          $table->id('uniqueIndex')->autoIncrement();

          $table->integer('sourceID');

          $table->string('itemTitle', 255);
          $table->string('itemLink', 1000);
          $table->string('itemDescription', 1000);
          $table->integer('itemDate');

          $table->string('channelTitle', 255);
          $table->string('channelLink', 255);
          $table->string('channelDescription', 255);

          $table->string('uniqueString', 250);

          $table->tinyInteger('hiddenRow');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rss_table_items');
    }
};
