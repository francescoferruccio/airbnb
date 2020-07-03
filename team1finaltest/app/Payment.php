<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  protected $table = 'payments';

  public function sponsorship() {
    return $this->belongsTo(Sponsorship::class);
  }
}
