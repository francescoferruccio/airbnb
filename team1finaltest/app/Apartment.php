<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Apartment extends Model
{
  protected $table = "apartments";

  public function services()
  {
    return $this->belongsToMany(Service::class);
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function requests()
  {
    return $this->hasMany(Request::class);
  }
  public function views()
  {
    return $this->hasMany(View::class);
  }
  public function sponsorships()
  {
    return $this->belongsToMany(Sponsorship::class)
                ->withPivot('transaction_id', 'end_sponsorship')
                ->withTimestamps();
  }

  public static function getByDistance($lat, $lng, $distance) {
    $results = DB::select(DB::raw('SELECT id, ( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $lng . ') ) + sin( radians(' . $lat .') ) * sin( radians(latitude) ) ) ) AS distance FROM apartments HAVING distance < ' . $distance . ' ORDER BY distance') );

    return $results;
  }
}
