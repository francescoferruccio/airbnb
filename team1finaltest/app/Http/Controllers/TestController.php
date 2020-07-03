<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartment;

class TestController extends Controller
{
  public function show($id) {
    $apartment = Apartment::findOrFail($id);

    return view('show', compact('apartment'));
  }
}
