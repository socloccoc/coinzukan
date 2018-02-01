<?php namespace App\Helpers;

use App\Models\Coin;
use App\Models\Markets;
use App\Models\Pair;
use Session;
use Input;
use URL;
use DB;
use Route;
use DateTime;

class BasicHelper
{

    public static function getSortableColumnOnArrayHomeCustom($array, $prefix = '')
    {
        $queryString = self::getQueryString($prefix);
        foreach ($array as $key => $value) {
            $array[$key] = self::getSortableColumnHomeCustom($key, $value, $queryString, $prefix);
        }
        return $array;
    }

    public static function getSortableColumnOnArray($array, $prefix = '')
    {
        $queryString = self::getQueryString($prefix);
        foreach ($array as $key => $value) {
            $array[$key] = self::getSortableColumn($key, $value, $queryString, $prefix);
        }
        return $array;
    }

    public static function getSortableColumnsSnapShots($array, $prefix = '', $date,$exchange)
    {
        $queryString = self::getQueryString($prefix);
        foreach ($array as $key => $value) {
            $array[$key] = self::getSortableColumnSnapShots($key, $value, $queryString, $prefix, $date, $exchange);
        }
        return $array;

    }

    public static function getSortableColumnOnArrayHome($array, $prefix = '')
    {
        Route::currentRouteName() == 'all.coins.marketcap' ? $array['percent_change_24h'] = '% 24h' : 'Change 24h';
        $queryString = self::getQueryString($prefix);
        foreach ($array as $key => $value) {
            $array[$key] = self::getSortableColumnHome($key, $value, $queryString, $prefix);
        }
        return $array;
    }

    /**
     * Function to get query string
     *
     * @return string
     */
    public static function getQueryString($prefix = '')
    {
        // Temp array
        $arr = array();
        // Array to ignore the parameters from the query string
        $ignore = array('page', 'dir', 'sort', $prefix . 'page', $prefix . 'sort', $prefix . 'dir');
        //return Input::all();
        // Get the desired array
        foreach (Input::all() as $key => $value) {
            if (!in_array($key, $ignore)) {
                $arr[] = $key . "=" . $value;
            }
        }

        // If the query string is present if not present
        if (count($arr) > 0) {
            return implode("&", $arr);
        } else {
            return "";
        }
    }

    /**
     * Function to get sortable column
     *
     * @param type $column
     * @param type $displayName
     * @return string
     */
    public static function getSortableColumn($column, $displayName, $queryString, $prefix = '')
    {
        $sort = Input::get($prefix . 'sort');
        $dir = strtolower(Input::get($prefix . 'dir'));
        $nextDir = 'asc';
        $arrow = '';
        if (strcasecmp($sort, $column) == 0) {
            switch ($dir) {
                case 'asc':
                    $arrow = '<img src="../../images/sort_asc.png"> ';
                    $nextDir = 'desc';
                    break;
                case 'desc':
                    $arrow = '<img src="../../images/sort_desc.png">';
                    $nextDir = 'asc';
                    break;
            }
        }

        $button = '<a style="color:#000" href="?' . (empty($queryString) ? '' : $queryString . '&') . $prefix . 'sort=' . $column . '&' . $prefix . 'dir=' . $nextDir . '">' . $displayName . $arrow . '</a>';
        return $button;
    }

    /**
     * Function to get sortable column
     *
     * @param type $column
     * @param type $displayName
     * @return string
     */
    public static function getSortableColumnSnapShots($column, $displayName, $queryString, $prefix = '', $date, $exchange)
    {
        $sort = Input::get($prefix . 'sort');
        $dir = strtolower(Input::get($prefix . 'dir'));
        $nextDir = 'asc';
        $arrow = '';
        if (strcasecmp($sort, $column) == 0) {
            switch ($dir) {
                case 'asc':
                    $arrow = '<img src="../../images/sort_asc.png"> ';
                    $nextDir = 'desc';
                    break;
                case 'desc':
                    $arrow = '<img src="../../images/sort_desc.png">';
                    $nextDir = 'asc';
                    break;
            }
        }

        $button = '<a href="/historical/'.$date. '?exchange=' .$exchange.'&' . (empty($queryString) ? '' : $queryString . '&') . $prefix . 'sort=' . $column . '&' . $prefix . 'dir=' . $nextDir . '">' . $displayName . $arrow . '</a>';

        return $button;
    }

    /**
     * Function to get sortable column
     *
     * @param type $column
     * @param type $displayName
     * @return string
     */
    public static function getSortableColumnHomeCustom($column, $displayName, $queryString, $prefix = '')
    {
        $sort = Input::get($prefix . 'sort');
        $dir = strtolower(Input::get($prefix . 'dir'));
        $nextDir = 'asc';
        $arrow = '';
        if (strcasecmp($sort, $column) == 0) {
            switch ($dir) {
                case 'asc':
                    $arrow = '<img src="../../images/sort_asc.png"> ';
                    $nextDir = 'desc';
                    break;
                case 'desc':
                    $arrow = '<img src="../../images/sort_desc.png">';
                    $nextDir = 'asc';
                    break;
            }
        }

        $button = '<a href="/home?' . (empty($queryString) ? '' : $queryString . '&') . $prefix . 'sort=' . $column . '&' . $prefix . 'dir=' . $nextDir . '">' . $displayName . $arrow . '</a>';
        return $button;
    }

    /**
     * Function to get sortable column
     *
     * @param type $column
     * @param type $displayName
     * @return string
     */
    public static function getSortableColumnHome($column, $displayName, $queryString, $prefix = '')
    {
        $sort = Input::get($prefix . 'sort');
        $dir = strtolower(Input::get($prefix . 'dir'));
        $nextDir = 'asc';
        $arrow = '';
        if (strcasecmp($sort, $column) == 0) {
            switch ($dir) {
                case 'asc':
                    $arrow = '<img src="../../images/sort_asc.png"> ';
                    $nextDir = 'desc';
                    break;
                case 'desc':
                    $arrow = '<img src="../../images/sort_desc.png">';
                    $nextDir = 'asc';
                    break;
            }
        }
        $paramPrefix = Route::currentRouteName() == 'all.coins.marketcap' ? '/home/all' : (Route::currentRouteName() == 'homeMarketCap' ? '/' : '');
        $button = '<a style="color:#000" href="'.$paramPrefix.'?' . (empty($queryString) ? '' : $queryString . '&') . $prefix . 'sort=' . $column . '&' . $prefix . 'dir=' . $nextDir . '">' . $displayName . $arrow . '</a>';
        return $button;
    }

    public static function renderNameMarketById($id){
        $market = Markets::where('id', $id)->first();
        return $nameMarket = $market->market_name;
    }

    public static function renderNameTargetById($id){
        $target = Pair::where('id', $id)->first();
        return $nameTarget = $target->target;
    }


    public static function renderNameCoinByCode($code){
        $code = strtoupper($code);
        $query = Coin::where('code', $code)->select('name')->first();
        return $query['name'];
    }

    public static function convertNumberToMonthString($number){

        $dateObj   = DateTime::createFromFormat('!m', $number);
        $monthName = $dateObj->format('F');
        return $monthName;
    }

    public static function getSortableColumnsHistoryVolume($array, $prefix = '')
    {
        $queryString = self::getQueryString($prefix);
        foreach ($array as $key => $value) {
            $array[$key] = self::getSortableColumnHistoryVolume($key, $value, $queryString, $prefix);
        }
        return $array;
    }

    public static function getSortableColumnHistoryVolume($column, $displayName, $queryString, $prefix = '')
    {
        $sort = Input::get($prefix . 'sort');
        $dir = strtolower(Input::get($prefix . 'dir'));
        $nextDir = 'asc';
        $arrow = '';
        if (strcasecmp($sort, $column) == 0) {
            switch ($dir) {
                case 'asc':
                    $arrow = '<img src="../../images/sort_asc.png"> ';
                    $nextDir = 'desc';
                    break;
                case 'desc':
                    $arrow = '<img src="../../images/sort_desc.png">';
                    $nextDir = 'asc';
                    break;
            }
        }

        $button = '<a href="currencies/volume/monthly?' . (empty($queryString) ? '' : $queryString . '&') . $prefix . 'sort=' . $column . '&' . $prefix . 'dir=' . $nextDir . '">' . $displayName . $arrow . '</a>';
        return $button;
    }


    public static function getPriceUsdBySymbol($symbol){
        $query = DB::table('coinmarketcaps')
                ->where('coinmarketcaps.symbol', $symbol)
                ->select('coinmarketcaps.price_usd')
                ->first();
        return $query->price_usd;
    }

    public static function getSortableColumnOnArrayCoins($array, $prefix = '')
    {
        Route::currentRouteName() == 'all.coins' ? $array['percent_24h'] = '% 24h' : 'Change 24h';
        $queryString = self::getQueryString($prefix);
        foreach ($array as $key => $value) {
            $array[$key] = self::getSortableColumnCoins($key, $value, $queryString, $prefix);
        }
        return $array;
    }

    /**
     * Function to get sortable column
     *
     * @param type $column
     * @param type $displayName
     * @return string
     */
    public static function getSortableColumnCoins($column, $displayName, $queryString, $prefix = '')
    {
        $sort = Input::get($prefix . 'sort');
        $dir = strtolower(Input::get($prefix . 'dir'));
        $nextDir = 'asc';
        $arrow = '';
        if (strcasecmp($sort, $column) == 0) {
            switch ($dir) {
                case 'asc':
                    $arrow = '<img src="../../images/sort_asc.png"> ';
                    $nextDir = 'desc';
                    break;
                case 'desc':
                    $arrow = '<img src="../../images/sort_desc.png">';
                    $nextDir = 'asc';
                    break;
            }
        }
        $paramPrefix = Route::currentRouteName() == 'coin.totalSupply' ? '/coin/totalSupply' : (Route::currentRouteName() == 'all.coins' ? '/coins/all' : '/coins');
        $button = '<a style="color:#000" href="'.$paramPrefix.'?' . (empty($queryString) ? '' : $queryString . '&') . $prefix . 'sort=' . $column . '&' . $prefix . 'dir=' . $nextDir . '">' . $displayName . $arrow . '</a>';
        return $button;
    }

    public static function getSortableColumnOnArrayTokens($array, $prefix = ''){
        $queryString = self::getQueryString($prefix);
        foreach ($array as $key => $value) {
            $array[$key] = self::getSortableColumnTokens($key, $value, $queryString, $prefix);
        }
        return $array;
    }

    /**
     * Function to get sortable column
     *
     * @param type $column
     * @param type $displayName
     * @return string
     */
    public static function getSortableColumnTokens($column, $displayName, $queryString, $prefix = '')
    {
        $sort = Input::get($prefix . 'sort');
        $dir = strtolower(Input::get($prefix . 'dir'));
        $nextDir = 'asc';
        $arrow = '';
        if (strcasecmp($sort, $column) == 0) {
            switch ($dir) {
                case 'asc':
                    $arrow = '<img src="../../images/sort_asc.png">';
                    $nextDir = 'desc';
                    break;
                case 'desc':
                    $arrow = '<img src="../../images/sort_desc.png">';
                    $nextDir = 'asc';
                    break;
            }
        }
        $paramPrefix = Route::currentRouteName() == 'tokens.totalSupply' ? '/tokens/totalSupply' : (Route::currentRouteName() == 'tokens.all' ? '/tokens/all' : '/tokens');
        $button = '<a href="'.$paramPrefix.'?' . (empty($queryString) ? '' : $queryString . '&') . $prefix . 'sort=' . $column . '&' . $prefix . 'dir=' . $nextDir . '">' . $displayName . $arrow . '</a>';
        return $button;
    }


    public static function getSortableColumnOnArrayNewsCoin($array, $prefix = '')
    {
        $queryString = self::getQueryString($prefix);
        foreach ($array as $key => $value) {
            $array[$key] = self::getSortableColumnsNewsCoin($key, $value, $queryString, $prefix);
        }
        return $array;
    }

    /**
     * Function to get sortable column
     *
     * @param type $column
     * @param type $displayName
     * @return string
     */
    public static function getSortableColumnsNewsCoin($column, $displayName, $queryString, $prefix = '')
    {
        $sort = Input::get($prefix . 'sort');
        $dir = strtolower(Input::get($prefix . 'dir'));
        $nextDir = 'asc';
        $arrow = '';
        if (strcasecmp($sort, $column) == 0) {
            switch ($dir) {
                case 'asc':
                    $arrow = '<img src="../../images/sort_asc.png"> ';
                    $nextDir = 'desc';
                    break;
                case 'desc':
                    $arrow = '<img src="../../images/sort_desc.png">';
                    $nextDir = 'asc';
                    break;
            }
        }

        $button = '<a href="new?' . (empty($queryString) ? '' : $queryString . '&') . $prefix . 'sort=' . $column . '&' . $prefix . 'dir=' . $nextDir . '">' . $displayName . $arrow . '</a>';
        return $button;
    }

}

