<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriceDiscountToUSGames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('us_games', function (Blueprint $table) {
          $table->decimal('priceDiscounted', 5, 2)->after('percentDiscounted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('us_games', function (Blueprint $table) {
          $table->dropColumn('priceDiscounted');
        });
    }
}
