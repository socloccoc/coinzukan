<?php

namespace App\Console\Commands;

use App\Models\Pair;
use App\Models\Coins;
use App\Models\CoinConvert;
use Illuminate\Console\Command;

class CoinConvertCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'CoinConvertCommand:CoinConvert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Coin Convert';

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
       // print_r($this->getNameCoin('btc'));die();
        $pair = Pair::select('base','target')->get();
        foreach ($pair as $item){
            $checkConvert = CoinConvert::where("base",$item['base'])
                ->where("target",$item['target'])
                ->first();
            if(is_null($checkConvert)){
                $coinConvert = new CoinConvert();
                $coinConvert->coin_convert_name = $this->getNameCoin($item['base']).':'.strtoupper($item['base']).'/'.strtoupper($item['target']);
                $coinConvert->base = $item['base'];
                $coinConvert->target = $item['target'];
                $coinConvert->save();
            }
        }
    }

    public function getNameCoin($symbol){
        $name = Coins::select('name')
            ->where('code',strtoupper($symbol))
            ->first();
        ;
        return $name['name'];
    }

}
