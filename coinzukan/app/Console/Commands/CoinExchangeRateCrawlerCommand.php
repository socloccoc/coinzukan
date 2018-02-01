<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CoinExchangeRate;

class CoinExchangeRateCrawlerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CoinExchangeRateCrawlerCommand:CoinExchangeRate';

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
        $url = 'https://api.coinmarketcap.com/v1/ticker/?convert=USD';
        $content = file_get_contents($url);
        $json = json_decode($content,true);

        foreach ($json as  $value) {
            $selectCoinExchangeRate = CoinExchangeRate::where('base', $value['symbol'])->first();
            if (!is_null($value['price_usd'])) {
                if ($selectCoinExchangeRate) {
                    //Update new value if exist
                    $selectCoinExchangeRate->exchange_usd = $value['price_usd'];
                    $selectCoinExchangeRate->save();
                } else {
                    // Insert new coin if not exist
                    $newValueChangeRate = new CoinExchangeRate();
                    $newValueChangeRate->base = $value['symbol'];
                    $newValueChangeRate->exchange_usd = $value['price_usd'];
                    $newValueChangeRate->save();
                }
            }
        }

    }
}
