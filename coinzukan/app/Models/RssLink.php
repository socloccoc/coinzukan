<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RssLink extends Model
{

    protected $table = 'dat_rss_link';
    protected $fillable = ['name', 'link', 'created_at', 'updated_at'];

}