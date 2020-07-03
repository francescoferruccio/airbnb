<?php

namespace App\Http\Controllers;
use App\User;
use App\Apartment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function create(){

      $user = Auth::user();
      return view('createApartment', compact('user'));
    }

    public function store(Request $request, $id){


      $user = User::findOrFail($id);

      $apartment = new Apartment;

      $validatedData = $request -> validate([
        "name" => "required|alpha",
        "description" => "required|alpha-num",
        "rooms" => "required|integer",
        "beds" => "required|integer",
        "bathrooms" => "required|integer",
        "size" => "required|numeric",
        "address" => "required|alpha-num",
        // "latitude" => "required|numeric",
        // "longitude" => "required|numeric",
        "picture" => "nullable"
        // "show" => "required|boolean"
      ]);

      $apartment -> name = $validatedData['name'];
      $apartment -> description = $validatedData['description'];
      $apartment -> rooms = $validatedData['rooms'];
      $apartment -> beds = $validatedData['beds'];
      $apartment -> bathrooms = $validatedData['bathrooms'];
      $apartment -> size = $validatedData['size'];
      $apartment -> address = $validatedData['address'];
      $apartment -> latitude = 23.764788;
      $apartment -> longitude =23.764788;
      $apartment -> picture = $validatedData['picture'];
      $apartment -> show = 1;
      $apartment -> user_id = $user -> id;

      $apartment -> save();

      return redirect() -> route('create');

    }
}
