<?php

namespace App\Console\Commands;

use App\Models\Pair;
use App\Models\Orderbook;
use App\Models\Trades;
use App\Models\Ohlc;
use App\Models\CoinConvert;
use App\Models\CoinExchangeRate;
use App\Models\ExchangeRateUsdMoneyOther;
use Illuminate\Console\Command;
use App\Models\Markets;

class DeleteAllTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    
    protected $signature = 'DeleteAllTable:DeleteAll';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'get all markets';

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
        Markets::truncate();
        Pair::truncate();
        Orderbook::truncate();
        Trades::truncate();
        Ohlc::truncate();
        CoinExchangeRate::truncate();
        CoinConvert::truncate();
        ExchangeRateUsdMoneyOther::truncate();
    }

}
