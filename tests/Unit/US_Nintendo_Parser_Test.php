<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\US_Game;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US_Nintendo_Parser_Test extends TestCase
{
  use RefreshDatabase;

    /**
     * Tests that the API URL returns a game object
     *
     * @return void
     */
    public function testAPIURLReturnsObjects()
    {
      $data = file_get_contents( env('NINTENDO_URL_US').'&offset=0');
      $data = json_decode($data, true);

      $this->assertTrue(array_key_exists('game',$data['games']));
    }

    /**
     * Tests the ability of the parser to update/inserta  game
     *
     * @return void
     */
    public function testParserCanInsertGame()
    {
      $game = new US_Game(
        [
          'nsuid' => '999999999',
          'title' => 'Ultra Cool Game',
          'eshop_price' => 9.99,
          'sale_price' => 0.00,
          'percentDiscounted' => 0,
          'priceDiscounted' => 0,
          'front_box_art' => 'https://google.com'
        ]
      );
      $nintendoGame = app('App\Console\Commands\ParseNintendoJSON')->insertOrUpdateGame($game,$game->sale_price,$game->percentDiscounted,$game->priceDiscounted);
      $this->assertDatabaseHas('us_games', ['nsuid' => '999999999']);
    }


    // /**
    //  * Tests that a game object can be entered into the database
    //  *
    //  * @return void
    //  */
    // public function testInsertGameIntoDatabase()
    // {
    //   $nintendoGame = US_Game::updateOrCreate(
    //     ['nsuid' => '999999999'],
    //     [
    //       'title' => 'Ultra Cool Game',
    //       'eshop_price' => 9.99,
    //       'sale_price' => 0.00,
    //       'percentDiscounted' => 0,
    //       'priceDiscounted' => 0,
    //       'front_box_art' => 'https://google.com'
    //     ]
    //   );
    //
    //   $this->assertDatabaseHas('us_games', ['nsuid' => '999999999']);
    // }
    // public function testNintendoParserCommand()
    // {
    //   $this->artisan('parse:nintendo_json')
    //     ->assertExitCode(0);
    // }
}
