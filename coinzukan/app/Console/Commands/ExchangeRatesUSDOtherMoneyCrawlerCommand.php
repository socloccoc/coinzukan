<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\ExchangeRateUsdMoneyOther;

class ExchangeRatesUSDOtherMoneyCrawlerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ExchangeRatesUSDOtherMoneyCrawlerCommand:ExchangeRatesUSDOtherMoney';

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
        $url = 'http://api.fixer.io/latest?base=USD';
        $content = file_get_contents($url);
        $json = json_decode($content, true);

        foreach ($json['rates'] as $key => $value) {
            $selectedValueChange = ExchangeRateUsdMoneyOther::where('name', $key)
            ->first();
            dd($selectedValueChange);

            if ($selectedValueChange) {
                //Update new value if exist
                $selectedValueChange->exchange_rate = $value;
                $selectedValueChange->save();
            } else {
                // Insert new coin if not exist
                $newValueChangeRate = new ExchangeRateUsdMoneyOther();
                $newValueChangeRate->name = $key;
                $newValueChangeRate->exchange_rate = $value;
                $newValueChangeRate->save();
            }
          }
        

    }
}
