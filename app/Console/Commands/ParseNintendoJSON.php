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
      $this->info(' ');

      while($gamesListed) {
        $data = file_get_contents( env('NINTENDO_URL_US').'&offset='.$offset);
        $data = json_decode($data, true);
        $this->info(' ');

        if(array_key_exists('game',$data['games'])){
          foreach ($data['games']['game'] as $game) {
            if(array_key_exists('eshop_price',$game) && array_key_exists('nsuid',$game)){

              $salePrice = $game['eshop_price'];
              $discountPercent = round(0);
              $discountPrice = 0;
              if(array_key_exists('sale_price',$game)){
                if($game['eshop_price'] > $game['sale_price']){
                  $salePrice = $game['sale_price'];
                  $discountPercent = round((($game['eshop_price'] - $salePrice) / $game['eshop_price']) * 100);
                  $discountPrice = $game['eshop_price'] - $salePrice;
                }
              }
              $nintendoGame = $this->insertOrUpdateGame($game,$salePrice,$discountPercent,$discountPrice);
              $this->logGameToOutput($nintendoGame);
            }
          }
          $offset = $offset + 50;
        }else{
          $gamesListed = false;
          $this->info('Done parsing games into the database');
        }
      }
    }

    public function insertOrUpdateGame($game,$salePrice,$discountPercent,$discountPrice)
    {
      $nintendoGame = US_Game::updateOrCreate(
        ['nsuid' => $game['nsuid']],
        [
          'title' => $game['title'],
          'eshop_price' => $game['eshop_price'],
          'sale_price' => $salePrice,
          'percentDiscounted' => $discountPercent,
          'priceDiscounted' => $discountPrice,
          'front_box_art' => $game['front_box_art']
        ]
      );
      return $nintendoGame;
    }

    public function logGameToOutput($nintendoGame)
    {
      $this->info('-------------------');
      $this->info('Title: '.$nintendoGame->title);
      $this->info('NSUID: '.$nintendoGame->nsuid);
      $this->info('Price: $'.$nintendoGame->eshop_price);
      $this->info('Sale Price: $'.$nintendoGame->sale_price);
      $this->info('Percent Discounted: '.$nintendoGame->percentDiscounted.'%');
      $this->info('Price Discounted: $'.sprintf("%0.2f",$nintendoGame->priceDiscounted));
      $this->info('Box Art: '.$nintendoGame->front_box_art);
      $this->info('-------------------');
      $this->info(' ');
    }
}
