<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    return $this->belongsToMany(Sponsorship::class);
  }
}
