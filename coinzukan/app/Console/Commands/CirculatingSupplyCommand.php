<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

use App\Models\CirculatingSupply;
use Mail;
class CirculatingSupplyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CirculatingSupplyCommand:CirculatingSupply';

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

        $data = array(array(
            'email' => 'daihusk57@gmail.com',
            'lastname' => 'daidv'),
            array(
                'email' => 'danghuuaha1@gmail.com',
                'lastname' => 'daidv'
            )
        );

        //dd($data);


        $emails = ['daihusk57@gmail.com', 'danghuuhai1@gmail.com'];

        Mail::send('emails.template', [], function($message) use ($emails)
        {
            $message->to($emails)->subject('This is test e-mail');
        });
        //var_dump( Mail:: failures());
       // exit;
//        $data = crawlUrl('https://api.coinmarketcap.com/v1/ticker/');
//        CirculatingSupply::truncate();
//        foreach ($data as $item){
//          $listCoin[] = [
//            'name' => isset($item['name']) ? $item['name'] : '',
//            'code' => isset($item['symbol']) ? $item['symbol'] : '',
//            'supply' => isset($item['total_supply']) ? $item['total_supply'] : ''
//          ];
//        }
//        CirculatingSupply::insert($listCoin);
    }
}
