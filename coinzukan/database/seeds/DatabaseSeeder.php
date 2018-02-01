<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call(CoinConvertSeeder::class);
        // $this->call(MarketSeeder::class);
        $this->call(SettingSeeder::class);
      
    }
}
