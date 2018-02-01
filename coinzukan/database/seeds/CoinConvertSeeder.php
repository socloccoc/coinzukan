<?php

use Illuminate\Database\Seeder;

class CoinConvertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // [BTC_BCN,BTC_BELA,BTC_BLK,BTC_BTCD,BTC_BTM,BTC_BTS,BTC_BURST,BTC_CLAM,BTC_DASH,BTC_DGB,BTC_DOGE
        //BTC_EMC2,BTC_FLDC ,BTC_FLO,BTC_GAME,BTC_GRC,BTC_HUC,BTC_LTC,BTC_MAID,BTC_OMNI,BTC_NAUT,BTC_NAV
        // BTC_NEOS,BTC_NMC,BTC_NOTE,BTC_NXT,BTC_PINK,BTC_POT,BTC_PPC,BTC_RIC,BTC_SJCX,BTC_STR,BTC_SYS
        // BTC_VIA,BTC_XVC,BTC_VRC,BTC_VTC,BTC_XBC,BTC_XCP,BTC_XEM,BTC_XMR,BTC_XPM,BTC_XRP,
        // BTC_SC,BTC_BCY ,BTC_EXP,BTC_FCT,BTC_AMP,
        // BTC_DCR,BTC_LSK,BTC_LBC,BTC_STEEM,BTC_SBD,BTC_ETC,BTC_REP,BTC_ARDR,BTC_ZEC,
        // BTC_STRAT,BTC_NXC ,BTC_PASC,BTC_GNT,BTC_GNO, BTC_BCH,BTC_ZRX,BTC_ETH,
        // ETH_GNO,ETH_REP,ETH_ZEC, ETH_STEEM,ETH_ETC,
        // 
        //,ETH_GNT,ETH_BCH,ETH_ZRX
        //XMR_ZEC, XMR_BCN,XMR_BLK,XMR_BTCD,XMR_DASH,XMR_LTC,XMR_MAID
        //XMR_NXT,
        //USDT_LTC,USDT_NXT ,USDT_STR,USDT_XMR,USDT_XRP,USDT_BTC,USDT_DASH,USDT_BCH,USDT_ETH,USDT_ETC,USDT_REP,USDT_ZEC,
       
        //]
        DB:: table('coin_convert')->insert([

            ['coin_convert_name'=>'ByteCoin:BCN/BTC', 'base'=>'BCN', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'BelaCoin:BELA/BTC', 'base'=>'BELA', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'BlackCoin:BLK/BTC','base'=>'BLK', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'BitcoinDarkCoin:BTCD/BTC','base'=>'BTCD', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'BitmarkCoin:BTM/BTC','base'=>'BTM', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'BitsharesCoin:BTS/BTC','base'=>'BTS', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'BurstCoin:BURST/BTC','base'=>'BURST', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'ClamCoin:CLAM/BTC','base'=>'CLAM', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'DashCoin:DASH/BTC','base'=>'DASH', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'DigibyteCoin:DGB/BTC','base'=>'DGB', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'Dogecoin:DOGE/BTC','base'=>'DOGE', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'EinsteiniumCoin:EMC2/BTC','base'=>'EMC2', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'FoldingCoin:FLDC/BTC','base'=>'FLDC', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'FlorinCoin:FLO/BTC','base'=>'FLO', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'GameCreditsCoin:GAME/BTC','base'=>'GAME', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'GridCoin:GRC/BTC','base'=>'GRC', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'HunterCoin:HUC/BTC','base'=>'HUC', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'LiteCoin:LTC/BTC','base'=>'LTC', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'MaidSafeCoin:MAID/BTC','base'=>'MAID', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'OmniCoin:OMNI/BTC','base'=>'OMNI', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'NautilusCoin:NAUT/BTC','base'=>'NAUT', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'NavCoin:NAV/BTC','base'=>'NAV', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=> 'NeosCoin:NEOS/BTC','base'=>'NEOS', 'target'=>'BTC', 'created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'NameCoin:NMC/BTC', 'base'=>'NMC', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'DNotesCoin:NOTE/BTC', 'base'=>'NOTE', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'NxtCoin:NXT/BTC', 'base'=>'NXT', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'PinkCoin:PINK/BTC', 'base'=>'PINK', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'PotCoin:POT/BTC', 'base'=>'POT', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'PeerCoin:PPC/BTC', 'base'=>'PPC', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'RieCoin:RIC/BTC', 'base'=>'RIC', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'StorjCoin:SJCX/BTC', 'base'=>'SJCX', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'StarCoin :STR/BTC', 'base'=>'STR', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'SysCoin:SYS/BTC', 'base'=>'SYS', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'ViaCoin :VIA/BTC', 'base'=>'VIA', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'VcashCoin:XVC/BTC', 'base'=>'XVC', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'VeriCoin:VRC/BTC', 'base'=>'VRC', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'VertCoin:VTC/BTC', 'base'=>'VTC', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'BitcoinPlus:XBC/BTC', 'base'=>'XBC', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'CounterPartyCoin:XCP/BTC', 'base'=>'XCP', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'NewEconomyMovementCoin:XEM/BTC', 'base'=>'XEM', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'MoneroCoin:XMR/BTC', 'base'=>'XMR', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'PrimeCoin:XPM/BTC', 'base'=>'XPM', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'RippleCoin:XRP/BTC', 'base'=>'XRP', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'SiaCoin:SC/BTC', 'base'=>'SC', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'BitCrystalsCoin:BCY/BTC', 'base'=>'BCY', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'ExpanseCoin:EXP/BTC', 'base'=>'EXP', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'FactomCoin:FCT/BTC', 'base'=>'FCT', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'SynereoCoin:AMP/BTC', 'base'=>'AMP', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'DecredCoin:DCR/BTC', 'base'=>'DCR', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'LiskCoin:LSK/BTC', 'base'=>'LSK', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'LBRYCreditsCoin:LBC/BTC', 'base'=>'LBC', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'SteemCoin:STEEM/BTC', 'base'=>'STEEM', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'SteemDollarsCoin:SBD/BTC', 'base'=>'SBD', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'EthereumClassicCoin :ETC/BTC', 'base'=>'ETC', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'AugurCoin:REP/BTC', 'base'=>'REP', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'ArdorCoin:ARDR/BTC', 'base'=>'ARDR', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'ZcashCoin:ZEC/BTC', 'base'=>'ZEC', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'StratisCoin:STRAT/BTC', 'base'=>'STRAT', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'NexiumCoin:NXC/BTC', 'base'=>'NXC', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'PascalCoin:PASC/BTC', 'base'=>'PASC', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'GolemCoin:GNT/BTC', 'base'=>'GNT', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'GnosisCoin:GNO/BTC', 'base'=>'GNO', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'BitcoinCash:BCH/BTC', 'base'=>'BCH', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'ZRXCoin:ZRX/BTC', 'base'=>'ZRX', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'EthereumCoin:ETH/BTC', 'base'=>'ETH', 'target'=>'BTC','created_at' => date("Y-m-d H:i:s") ],

            ['coin_convert_name'=>'GnosisCoin:GNO/ETH', 'base'=>'GNO', 'target'=>'ETH','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'AugurCoin:REP/ETH', 'base'=>'REP', 'target'=>'ETH','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'ZcashCoin:ZEC/ETH', 'base'=>'ZEC', 'target'=>'ETH','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'SteemCoin:STEEM/ETH', 'base'=>'STEEM', 'target'=>'ETH','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'EthereumClassicCoin:ETC/ETH', 'base'=>'ETC', 'target'=>'ETH','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'BitcoinCash:BCH/ETH', 'base'=>'BCH', 'target'=>'ETH','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'GolemCoin:GNT/ETH', 'base'=>'GNT', 'target'=>'ETH','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'ZRXCoin:ZRX/ETH', 'base'=>'ZRX', 'target'=>'ETH','created_at' => date("Y-m-d H:i:s") ],
            
            ['coin_convert_name'=>'ZcashCoin:ZEC/XMR', 'base'=>'ZEC', 'target'=>'XMR','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'ByteCoin:BCN/XMR', 'base'=>'BCN', 'target'=>'XMR','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'BlackCoin:BLK/XMR', 'base'=>'BLK', 'target'=>'XMR','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'BitcoinDarkCoin:BTCD/XMR', 'base'=>'BTCD', 'target'=>'XMR','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'DashCoin:DASH/XMR', 'base'=>'DASH', 'target'=>'XMR','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'LiteCoin:LTC/XMR', 'base'=>'LTC', 'target'=>'XMR','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'MaidSafeCoin:MAID/XMR', 'base'=>'MAID', 'target'=>'XMR','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'NxtCoin:NXT/XMR', 'base'=>'NXT', 'target'=>'XMR','created_at' => date("Y-m-d H:i:s") ],
            
            ['coin_convert_name'=>'LiteCoin:LTC/USDT', 'base'=>'LTC', 'target'=>'USDT','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'NxtCoin:NXT/USDT', 'base'=>'NXT', 'target'=>'USDT','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'StarCoin:STR/USDT', 'base'=>'STR', 'target'=>'USDT','created_at' => date("Y-m-d H:i:s") ],            
            ['coin_convert_name'=>'MoneroCoin:XMR/USDT', 'base'=>'XMR', 'target'=>'USDT','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'RippleCoin:XRP/USDT', 'base'=>'XRP', 'target'=>'USDT','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'BitCoin:BTC/USDT', 'base'=>'BTC', 'target'=>'USDT','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'DashCoin:DASH/USDT', 'base'=>'DASH', 'target'=>'USDT','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'BitcoinCash:BCH/USDT', 'base'=>'BCH', 'target'=>'USDT','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'EthereumCoin:ETH/USDT', 'base'=>'ETH', 'target'=>'USDT','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'EthereumClassicCoin:ETC/USDT,', 'base'=>'ETC', 'target'=>'USDT','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'AugurCoin:REP/USDT', 'base'=>'REP', 'target'=>'USDT','created_at' => date("Y-m-d H:i:s") ],
            ['coin_convert_name'=>'ZcashCoin:ZEC/USDT', 'base'=>'ZEC', 'target'=>'USDT','created_at' => date("Y-m-d H:i:s") ],
            
]);
    }
}
