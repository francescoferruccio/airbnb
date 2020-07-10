<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Request;

class View extends Model
{
  protected $table = "views";

  public function apartment()
  {
    return $this->belongsTo(Apartment::class)->withTimestamps();
  }

  public static function createView($apartment) {
    if(Auth::check()) {
      $user_id = Auth::user()->id;
    }

    if(!isset($user_id) || $user_id != $apartment['user_id']) {
      $ipAddress = Request::getClientIp();
      $lastview = DB::table('views')->where([
        ['ip_address', $ipAddress],
        ['apartment_id', $apartment['id']]
        ])->orderBy('created_at', 'desc')->first();

        if($lastview != null) {
          $expiry = $lastview->expiry;
          $now = now()->toDateTimeString();

          if($now > $expiry) {
            storeView($apartment, $ipAddress);
          }
        } else {
          storeView($apartment, $ipAddress);
        }
      }
    }
}

function storeView($apartment, $ipAddress) {
  $apartmentViews= new View();

  $apartmentViews->apartment_id = $apartment->id;
  $apartmentViews->ip_address = $ipAddress;
  $apartmentViews->expiry = now()->addHour()->toDateTimeString();
  $apartmentViews->save();
}
