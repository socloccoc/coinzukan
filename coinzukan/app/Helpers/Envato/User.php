<?php
//app/Helpers/Envato/User.php
namespace App\Helpers\Envato;

use Illuminate\Support\Facades\DB;

class User {
  /**
   * @param int $user_id User-id
   *
   * @return string
   */
  public static function get_username($user_id) {
    return $user_id;
  }
}