<?php

use Illuminate\Database\Seeder;

class MarketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         DB:: table('market')->insert([
                    ['name'=>'Poloniex','created_at' => date("Y-m-d H:i:s") ],
                    ['name'=>'Bittrex','created_at' => date("Y-m-d H:i:s") ],
         ]);
    }
}
