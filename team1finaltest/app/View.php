<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
  protected $table = "views";

  public function apartment()
  {
    return $this->belongsTo(Apartment::class);
  }
}
