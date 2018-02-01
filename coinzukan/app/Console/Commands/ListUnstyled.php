<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte;
use App\Models\Coinmarketcap;
use App\Models\ListUnstyled as ListUns;
use App\Models\ListUnstyledJapan;

class ListUnstyled extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'ListUnstyled:command';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

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
    $this->ListUnstyleJp();
  }

  public function ListUnstyleJp()
  {
    $url = 'https://coinmarketcap.com/zh/currencies/';
    $this->crawlData($url);
  }

  public function ListUnstyleEn(){
    $url = 'https://coinmarketcap.com/currencies/';
    $this->crawlData($url);
  }

  public function crawlData($url)
  {
    $coins = Coinmarketcap::select('name')->get();
    $data = [];
    foreach ($coins as $index => $coin) {
      $coin_name = strtolower(str_replace(" ", "-", $coin['name']));
      echo $coin_name . "\n";
      //$url = 'https://coinmarketcap.com/currencies/' . $coin_name;
      $crawler = Goutte::request('GET', $url.$coin_name);
      $subData = [];
      $subData['coin_name'] = $coin['name'];
      $crawler->filterXPath('//ul[@class="list-unstyled"]/li')->each(function ($node, $index) use (&$subData, &$data) {
        $glyphicon = '';
        $node->filter('span')->each(function ($item, $count) use (&$index, &$subData, &$glyphicon) {
          if ($count == 0) {
            $subData['glyphicon' . ($index + 1)] = $glyphicon = $item->attr('class');
          } else {
            if ($glyphicon == 'glyphicon glyphicon glyphicon-star text-gray') {
              $subData['rank'] = $item->text();
            } else {
              if ($count == 1) {
                $subData['label1'] = $item->text();
              } else if ($count == 2) {
                $subData['label2'] = $item->text();
              }
            }
          }
        });
        $node->filter('a')->each(function ($item) use (&$index, &$subData) {
          $subData['title' . ($index + 1)] = $item->text();
          $subData['link' . ($index + 1)] = $item->attr('href');
        });
      });
      $data[] = $subData;
      if($url == 'https://coinmarketcap.com/currencies/'){
        ListUns::insert($subData);
      }else{
        ListUnstyledJapan::insert($subData);
      }
    }
  }
}
