<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        '\App\Console\Commands\GetAllMarketsCrawlerCommand',
        '\App\Console\Commands\DeleteAllTableCommand',
        '\App\Console\Commands\CoinConvertCommand',
        '\App\Console\Commands\CoinExchangeRateCrawlerCommand',
        '\App\Console\Commands\ExchangeRatesUSDOtherMoneyCrawlerCommand',
        '\App\Console\Commands\CoinsCrawlerCommand',
        '\App\Console\Commands\CirculatingSupplyCommand',
        '\App\Console\Commands\DeletePriceHistory7DCommand',
        '\App\Console\Commands\CoinmarketcapsCommand',
        '\App\Console\Commands\CoinmarketcapsGlobalCommand',
        '\App\Console\Commands\GetHistoryVolumeCoinMarketCap',
        '\App\Console\Commands\GetNewCurrencyMarketCap',
        '\App\Console\Commands\ListUnstyled',

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

//        $schedule->command('CoinsCrawlerCommand:CoinsInfo')
//                 ->dailyAt('12:00');
//        $schedule->command('CoinConvertCommand:CoinConvert')
//                 ->dailyAt('12:05');
//        $schedule->command('CoinExchangeRateCrawlerCommand:CoinExchangeRate')
//                 ->dailyAt('12:10');
//        $schedule->command('ExchangeRatesUSDOtherMoneyCrawlerCommand:ExchangeRatesUSDOtherMoney')
//                 ->dailyAt('12:15');
//        // coinmarketcap
//        $schedule->command('GetAllMarketsCrawler:GetAllMarkets')
//            ->hourly();
//        $schedule->command('CoinmarketcapsGlobalCommand:CoinmarketcapsGlobal')
//            ->hourly();
//        $schedule->command('getSnapShootHistory:Start')
//            ->weekly();
//        $schedule->command('gethistoryvolumecoimarketcap:start')
//            ->daily('13:00');
//        $schedule->command('getNewCurrencyMarketcap:Start')
//            ->daily('13:30');
//        //
//        $schedule->command('CirculatingSupplyCommand:CirculatingSupply')
//                 ->daily();
//        $schedule->command('DeletePriceHistory7DCommandPriceHistory7DCommand:DeletePriceHistory7D')
//                 ->dailyAt('12:20');
//        $schedule->command('DeleteAllTable:DeleteAll')
//                 ->monthlyOn(1, '10:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
