<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survivor_inventories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('survivor_id');
            $table->foreign('survivor_id')->references('id')->on('survivors')->cascadeOnDelete();

            $table->foreignId('item_id');
            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();

            $table->integer('amount')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survivor_inventories');
    }
};
