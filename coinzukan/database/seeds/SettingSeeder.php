<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        DB:: table('settings')->insert([
            ['version'=>'1.0',
            'messages'=>'Coins of the United States dollar were first minted in 1792. New coins have been produced annually since then and they make up a valuable aspect of the United States currency system.
             Today, circulating coins exist in denominations of 1¢ (i.e. 1 cent or $0.01), 5¢, 10¢, 25¢, 50¢, and $1.00. Also minted are bullion (including gold, silver and platinum) and commemorative coins. All of these are produced by the United States Mint. The coins are then sold to Federal Reserve Banks which in turn are responsible for putting coins into circulation and withdrawing them as demanded by the country',
            'TermsAndPrivacy'=>'A Privacy Policy agreement is required by law if you collect or use any personal information from your users, e.g. email addresses, first and last names etc. The purpose of this agreement is to inform users about your collection and use of personal data of users.
            A Terms & Conditions (T&C) agreement sets forth terms, conditions, requirements, and clauses relating to the use of your website or mobile/desktop app, e.g. copyright protection, accounts termination in cases of abuses, and so on.',
             'created_at' => date("Y-m-d H:i:s") ],
        
             ]);
    }
}
