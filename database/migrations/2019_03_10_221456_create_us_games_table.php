<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('us_games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nsuid');
            $table->string('title');
            $table->decimal('eshop_price', 5, 2);
            $table->decimal('sale_price', 5, 2);
            $table->string('front_box_art');
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
        Schema::dropIfExists('us_games');
    }
}
