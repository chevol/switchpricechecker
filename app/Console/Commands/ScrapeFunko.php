<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte;

class ScrapeFunko extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:funko';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Funko POP! Vinyl Scraper';

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
      $collections = [
          'pop-vinyl',
      ];

      foreach ($collections as $collection) {
        $this->scrape($collection);
      }
    }

    /**
   * For scraping data for the specified collection.
   *
   * @param  string $collection
   * @return boolean
   */
    public static function scrape($collection)
    {
        // $crawler = Goutte::request('GET', env('FUNKO_POP_URL').'/'.$collection);
        //
        // $pages = ($crawler->filter('footer .pagination li')->count() > 0)
        //     ? $crawler->filter('footer .pagination li:nth-last-child(2)')->text()
        //     : 0
        // ;
// $pages = 1;
//         for ($i = 0; $i < $pages + 1; $i++) {
//             if ($i != 0) {
//                 $crawler = Goutte::request('GET', env('FUNKO_POP_URL').'/'.$collection.'?page='.$i);
//             }
//             $crawler = Goutte::request('GET', env('NINTENDO_URL_US'));
//           //  dd($crawler);
//           //$response = $crawler->send(); // Send created request to server
// //$data = $crawler->json();
//
//           $area = json_decode($crawler, true);
// dump($area);

$data = file_get_contents( env('NINTENDO_URL_US').'&offset=50');

    $data = json_decode($data);
    foreach ($data->games as $game) {
      // code...

      dump($game);
    }
          // foreach($area['area'] as $i => $v)
          // {
          //     echo $v['area'].'<br/>';
          // }

            // $crawler->filter('.info > h3 ')->each(function ($node) {
            //   //print('1');
            //    dump($node->text());
            //   //  $sku   = explode('#', $node->filter('.product-sku')->text())[1];
            //     //$title = trim($node->filter('.title a')->text());
            //
            //   //  print_r($sku.', '.$title);
            // });
          // $crawler = Goutte::request('GET', 'https://duckduckgo.com/html/?q=Laravel');
          // $crawler->filter('.result__title .result__a')->each(function ($node) {
          //   dump($node->text());
          // });
      //  }

        return true;
    }
}
