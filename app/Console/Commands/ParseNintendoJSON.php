<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\US_Game;

class ParseNintendoJSON extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:nintendo_json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse Nintendo JSON to get Switch game data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $offset = 0;
      $gamesListed=true;
      $this->info('Nintendo US Parser - starting to parse game data...');
      US_Game::truncate();
      
      while($gamesListed) {
        $data = file_get_contents( env('NINTENDO_URL_US').'&offset='.$offset);
        $data = json_decode($data, true);
        $this->info(' ');

        if(array_key_exists('game',$data['games'])){
          foreach ($data['games']['game'] as $game) {
            if(array_key_exists('eshop_price',$game) && array_key_exists('nsuid',$game)){
              $this->info('Inserting the following into the database:');

              $newGame = new US_Game;
              $newGame->nsuid = $game['nsuid'];
              $newGame->title = $game['title'];
              $newGame->eshop_price = $game['eshop_price'];
              $newGame->sale_price = array_key_exists('sale_price',$game) ? $game['sale_price'] : $game['eshop_price'];
              $newGame->front_box_art = $game['front_box_art'];
              $newGame->save();

              $this->info('NSUID: '.$newGame->nsuid);
              $this->info('Title: '.$newGame->title);
              $this->info('Price: '.$newGame->eshop_price);
              $this->info('Sale Price: '.$newGame->sale_price);
              $this->info('Box Art: '.$newGame->front_box_art);
              $this->info('-------------------');
              $this->info(' ');
            }
          }
          $offset = $offset + 50;
        }else{
          $gamesListed = false;
          $this->info(' ');
          $this->info('Done parsing games into the database');
        }
      }
    }
}
