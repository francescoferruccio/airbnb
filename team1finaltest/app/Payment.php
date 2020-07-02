<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  protected $table = "payments";

  public function apartment()
  {
    return $this->belongsTo(Apartment::class);
  }
}
