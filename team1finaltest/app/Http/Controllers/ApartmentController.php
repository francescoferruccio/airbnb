<?php

namespace App\Http\Controllers;
use App\User;
use App\Apartment;
use App\Service;
use Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApartmentController extends Controller
{
  // FUNZION INDEX - LISTA APPARTAMENTI SPONSORIZZATI NELLA HOME
  public function index() {
    // seleziono gli appartamenti che hanno una sponsorizzazione attiva
    $sponsored = Apartment::whereHas('sponsorships', function($q) {
      $q->where([
        ['apartment_sponsorship.end_sponsorship', '>', now()],
        ['show', '=', 1]
        ]);
    })->get();

    return view('home', compact('sponsored'));
  }

  // FUNZIONE SHOW
  public function show($id) {
    $apartment = Apartment::findOrFail($id);

    return view('show', compact('apartment'));
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

    // OTTENERE COORDINATE GEOLOCALIZZAZIONE (TomTom API)
    // $key = "gvHkFTj7nzPqQoErkvrc7G0bmBdQX4RF";
    // $address = $validatedData['address']; // Google HQ
    // $prepAddr = str_replace(' ','+',$address);
    // $geocode=file_get_contents('https://api.tomtom.com/search/2/geocode/'.$address .'.json?limit=1&key=' . $key);
    // $output= json_decode($geocode);
    // $latitude = $output->results[0]->position->lat;
    // $longitude = $output->results[0]->position->lon;

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

    return redirect() -> route('user')
    -> with("status","Appartamento aggiunto con successo");
  }

  public function edit($id) {
    $apartment = Apartment::findOrFail($id);
    $services = Service::all();

    return view('edit', compact('apartment', 'services'));
  }

  public function update(Request $request, $id) {
    $validatedData = $request->validate([
      "name" => "required|string",
      "description" => "required|string",
      "rooms" => "required|integer",
      "beds" => "required|integer",
      "bathrooms" => "required|integer",
      "size" => "required|numeric",
      "address" => "required|string",
      "picture" => "image|mimes:jpeg,bmp,png,jpg|max:5000",
      "services" => "nullable|array",
      "show" => "required|boolean"
    ]);

    // OTTENERE COORDINATE GEOLOCALIZZAZIONE
    $key = "&key=AIzaSyAP3Uq9YyadYgRoX3N_l4rKUN25UD6Zkgo";
    $address = $validatedData['address']; // Google HQ
    $prepAddr = str_replace(' ','+',$address);
    $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false' . $key);
    $output= json_decode($geocode);
    $latitude = $output->results[0]->geometry->location->lat;
    $longitude = $output->results[0]->geometry->location->lng;

    // OTTENERE COORDINATE GEOLOCALIZZAZIONE (TomTom API)
    // $key = "gvHkFTj7nzPqQoErkvrc7G0bmBdQX4RF";
    // $address = $validatedData['address']; // Google HQ
    // $prepAddr = str_replace(' ','+',$address);
    // $geocode=file_get_contents('https://api.tomtom.com/search/2/geocode/'.$address .'.json?limit=1&key=' . $key);
    // $output= json_decode($geocode);
    // $latitude = $output->results[0]->position->lat;
    // $longitude = $output->results[0]->position->lon;

    // ISTANZA DI UN NUOVO APPARTAMENTO
    $apartment = Apartment::findOrFail($id);
    //ASSEGNARE LE COLONNE DELL'APPARTAMENTO CON RELATIVI CAMPI
    $apartment -> name = $validatedData['name'];
    $apartment -> description = $validatedData['description'];
    $apartment -> rooms = $validatedData['rooms'];
    $apartment -> beds = $validatedData['beds'];
    $apartment -> bathrooms = $validatedData['bathrooms'];
    $apartment -> size = $validatedData['size'];
    $apartment -> address = $validatedData['address'];
    $apartment -> latitude = $latitude;
    $apartment -> longitude = $longitude;
    $apartment -> show = $validatedData['show'];

    if (array_key_exists('picture', $validatedData)) {
      //VALIDAZIONE DELL'IMAGE CARICATA LATO CLIENT
      $image = $request->file('picture');
      $name = Str::slug($request->input('name')).'_'.time();
      $ext = $image->getClientOriginalExtension();
      $folder = '/uploads/images/';
      $filePath = $folder . $name. '.' . $ext;

      $apartment -> picture = $filePath;

      $image->storeAs($folder, $name.'.'.$ext, "public");
    }

    $apartment -> save();

    // VALIDAZIONE DEI SERVIZI E RELAZIONARLI ALL'APPARTAMENTO
    if (!array_key_exists('services',$validatedData)) {
      $apartment -> services() -> sync([]);
    }else {
      $apartment -> services() -> sync($validatedData['services']);
    }

    return redirect() -> route('user')
    -> with("status","Appartamento modificato con successo");
  }

  public function search(Request $request) {
    // dd($request);
    $validatedData = $request->validate([
      'address' => 'required|string',
      'radius' => 'required|integer',
      'rooms' => 'required|integer',
      'beds' => 'required|integer',
      'services' => 'array'
    ]);


    // OTTENERE COORDINATE GEOLOCALIZZAZIONE
    $key = "&key=AIzaSyAP3Uq9YyadYgRoX3N_l4rKUN25UD6Zkgo";
    $address = $validatedData['address']; // Google HQ
    $prepAddr = str_replace(' ','+',$address);
    $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr . $key);
    $output= json_decode($geocode);
    //Se dall'input arriva un indirizzo valido
    if($output->status == 'OK') {
      $latitude = $output->results[0]->geometry->location->lat;
      $longitude = $output->results[0]->geometry->location->lng;
      $lat = $latitude;
      $lng = $longitude;
      $distance = $validatedData['radius'];

      $query = Apartment::getByDistance($lat, $lng, $distance);

      //Se non si trova un appartamento nella zona ricercata
      if(empty($query)) {
        return redirect()->route('home')->withErrors(['Nessun appartamento trovato']);
      }

      $ids = [];


      //Extract the id's
      foreach($query as $apartment)
      {
        array_push($ids, $apartment->id);
      }

      // richiamo la funzione filtro e salvo il risultato
      $apartments = self::filter($ids, $validatedData);
      if(!count($apartments)) {
        return redirect()->route('home')->withErrors(['Nessun appartamento soddisfa le tue richieste.']);
      } else {
        return view('search', compact('apartments'));
      }

    } else {
      return redirect()->route('home')->withErrors(['Inserisci un indirizzo valido']);
    }

  }

  // FUNZIONE FILTRO PARAMETRI RICERCA
  public function filter($ids, $validatedData) {
    $apartments = [];
    $apServices = [];
    // Pusho dentro apartments gli appartamenti con gli id che ritornano dalla ricerca, gia ordinati per distanza
    foreach ($ids as $id) {
      $apartment = Apartment::findOrFail($id);
      // se l'appartamento è visibile
      if($apartment['show'] == 1) {
        // se il numero di stanze e letti dell'appartamento sono >= a quelli richiesti
        if(($apartment['rooms'] >= $validatedData['rooms']) &&
          ($apartment['beds'] >= $validatedData['beds'])){
            // controlliamo se c'è un filtro sui servizi
            if(array_key_exists('services', $validatedData)) {
              $reqServices = $validatedData['services'];
              foreach ($apartment->services as $service) {
                $apServices[] = $service->id;
              }
              $count = count($reqServices);
              // controllo corrispondenza tra servizi richiesti e servizi dell'appartamento
              if((count(array_intersect($apServices, $reqServices)) == $count)) {
                $apartments[] = Apartment::findOrFail($id);
              }
            } else {
              $apartments[] = Apartment::findOrFail($id);
            }
          }
      } return $apartments;
    }
  }
}
