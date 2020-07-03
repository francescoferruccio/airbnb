<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
  protected $table = 'sponsorships';

  public function apartments() {
    return $this->belongsToMany(Apartment::class)->withTimestamps();
  }

  public function payments() {
    return $this->hasMany(Payment::class);
  }
}
