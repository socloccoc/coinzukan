<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RssLinkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dat_rss_link')->insert(
            [
                [
                    'name'  =>  'Bitcoinist',
                    'link'  =>  'http://bitcoinist.com/feed/',
                    'created_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'name'  =>  'Bitcoin Magazine',
                    'link'  =>  'https://bitcoinmagazine.com/feed/',
                    'created_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'name'  =>  'Bitcoin Warrior',
                    'link'  =>  'https://bitcoinwarrior.net/feed/',
                    'created_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'name'  =>  'CoinDesk',
                    'link'  =>  'https://www.coindesk.com/feed/',
                    'created_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'name'  =>  'CoinTelegraph',
                    'link'  =>  'https://cointelegraph.com/feed/',
                    'created_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'name'  =>  'Cryptocoin News',
                    'link'  =>  'https://www.cryptocoinsnews.com/feed/',
                    'created_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                ]
            ]
        );
    }
}
