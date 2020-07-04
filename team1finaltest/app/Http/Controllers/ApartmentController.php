<?php

namespace App\Http\Controllers;
use App\User;
use App\Apartment;
use App\Service;
use Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function create(){

      $services = Service::all();
      $user = Auth::user();
      return view('createApartment', compact('user','services'));
    }

    public function store(Request $request, $id){


      $user = User::findOrFail($id);

      $apartment = new Apartment;

      $validatedData = $request -> validate([
        "name" => "required|string",
        "description" => "required|string",
        "rooms" => "required|integer",
        "beds" => "required|integer",
        "bathrooms" => "required|integer",
        "size" => "required|numeric",
        "address" => "required|string",
        // "latitude" => "required|numeric",
        // "longitude" => "required|numeric",
        "picture" => "required|image|mimes:jpeg,bmp,png,jpg|max:5000",
        "services" => "nullable|array"
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
      $apartment -> show = 1;
      $apartment -> user_id = $user -> id;

      //VALIDAZIONE DELL'IMAGE CARICATA LATO CLIENT
      $image = $request->file('picture');
      $name = Str::slug($request->input('name')).'_'.time();
      $ext = $image->getClientOriginalExtension();
      $folder = '/uploads/images/';
      $filePath = $folder . $name. '.' . $ext;

      $apartment -> picture = $filePath;

      $image->storeAs($folder, $name.'.'.$ext, "public");

      $apartment -> save();

      // VALIDAZIONE DEI SERVIZI E RELAZIONARLI ALL'APPARTAMENTO
        if (!array_key_exists('services',$validatedData)) {
          $apartment -> services() -> sync([]);
        }else {
          $apartment -> services() -> sync($validatedData['services']);
        }

      return redirect() -> route('create')
                        -> with("status","Appartamento aggiunto con successo");
    }
}
