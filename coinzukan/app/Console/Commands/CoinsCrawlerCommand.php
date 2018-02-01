<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Coins;
use Response;

class CoinsCrawlerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CoinsCrawlerCommand:CoinsInfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get info coind';

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

        $url = 'https://www.cryptocompare.com/api/data/coinlist/';
        $content = file_get_contents($url);
        $json = json_decode($content, true);
        $baseImageUrl = $json['BaseImageUrl'];

        $indexExits = 0;
        $indexNew = 0;
        foreach ($json['Data'] as $value) {

            $ImgUrl = isset($value['ImageUrl']) ? $value['ImageUrl'] : '';
            $myArray = explode('/', trim($ImgUrl));
            $nameImg = $myArray[count($myArray) - 1];

            // download image
            if ($ImgUrl != '') {
                if (!file_exists('public/images/coin_icon/' . $nameImg)) {
                    $indexNew++;
                    $url = $baseImageUrl . $ImgUrl;
                    $img = 'public/images/coin_icon/' . $nameImg;
                    file_put_contents($img, file_get_contents($url));
                } else {
                    var_dump($nameImg . 'File exit');
                    $indexExits++;
                }

            }
            // check image url local
            if ($ImgUrl != '') {
                $imgUrlLocal = '/images/coin_icon/' . $nameImg;
            } else {
                $imgUrlLocal = '/images/coin_icon/icon_coin_default.png';
            }
            $selectCoin = Coins::where('code', $value['Name'])
                ->first();
            if ($selectCoin) {
                $selectCoin->name = $value['CoinName'];
                $selectCoin->icon_url = $imgUrlLocal;
                $selectCoin->save();
            } else {
                $newCoin = new Coins();
                $newCoin->code = $value['Name'];
                $newCoin->name = $value['CoinName'];
                $newCoin->icon_url = $imgUrlLocal;
                $newCoin->save();
            }
        }
    }


}
