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
  // FUNZION INDEX - LISTA APPARTAMENTI SPONSORIZZATI NELLA HOME
  public function index() {
    // seleziono gli appartamenti che hanno una sponsorizzazione attiva
    $sponsored = Apartment::whereHas('sponsorships', function($q) {
      $q->where('apartment_sponsorship.end_sponsorship', '>', now());
    })->get();

    return view('index', compact('sponsored'));
  }

  // FUNZIONE CREATE APPARTAMENTO
  public function create(){

    $services = Service::all();
    // RIMUOVERE L'UNDERSCORE DAI NOMI DEI SERVIZI PER STAMPARLI COME LABEL NEL FORM
    foreach ($services as $key => $service) {
      if (strpos($service -> name, '_')) {
        $service -> name = str_replace("_", " ", $service -> name);
      }
    }
    // USER AUTENTICATO
    $user = Auth::user();
    return view('createApartment', compact('user','services'));
  }

  // FUNZIONE STORE APPARTAMENTO
  public function store(Request $request, $id){

    $user = User::findOrFail($id);

    // VALIDAZIONE DATA ARRIVATI DAL FORM CREATE
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


    // OTTENERE COORDINATE GEOLOCALIZZAZIONE
    $key = "&key=AIzaSyAP3Uq9YyadYgRoX3N_l4rKUN25UD6Zkgo";
    $address = $validatedData['address']; // Google HQ
    $prepAddr = str_replace(' ','+',$address);
    $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false' . $key);
    $output= json_decode($geocode);
    $latitude = $output->results[0]->geometry->location->lat;
    $longitude = $output->results[0]->geometry->location->lng;

    // ISTANZA DI UN NUOVO APPARTAMENTO
    $apartment = new Apartment;
    //ASSEGNARE LE COLONNE DELL'APPARTAMENTO CON RELATIVI CAMPI
    $apartment -> name = $validatedData['name'];
    $apartment -> description = $validatedData['description'];
    $apartment -> rooms = $validatedData['rooms'];
    $apartment -> beds = $validatedData['beds'];
    $apartment -> bathrooms = $validatedData['bathrooms'];
    $apartment -> size = $validatedData['size'];
    $apartment -> address = $validatedData['address'];
    $apartment -> latitude = $latitude;
    $apartment -> longitude =$longitude;
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

    return redirect() -> route('home')
    -> with("status","Appartamento aggiunto con successo");
  }
}
