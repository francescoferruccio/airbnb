<?php

namespace App\Http\Controllers;
use App\User;
use App\Apartment;
use App\Service;
use App\View;
use App\Message;
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

    View::createView($apartment);

    foreach ($apartment->sponsorships as $sponsorship) {
      $end_sponsorship = $sponsorship->pivot->end_sponsorship;
    }

    $active = true;
    if(count($apartment->sponsorships) == 0 || $end_sponsorship < now()) {
      $active = false;
    }

    $user_id = null;
    if(Auth::check()) {
      $user_id = Auth::user()->id;
    }

    return view('show', compact('apartment', 'active', 'user_id'));
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
    if (checkPost($request)) {
      $user = User::findOrFail($id);

      // VALIDAZIONE DATA ARRIVATI DAL FORM CREATE
      $validatedData = $request -> validate([
        "name" => "required|string",
        "description" => "required|string",
        "rooms" => "required|integer|min:1|max:50",
        "beds" => "required|integer|min:1|max:50",
        "bathrooms" => "required|integer|min:1|max:50",
        "size" => "required|numeric",
        "address" => "required|string",
        "picture" => "required|image|mimes:jpeg,bmp,png,jpg|max:5000",
        "services" => "nullable|array"
      ]);

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
      $apartment -> latitude = getGeocode("lat", $validatedData);
      $apartment -> longitude = getGeocode("lng", $validatedData);
      $apartment -> show = 1;
      $apartment -> user_id = $user -> id;

      //Convertire l'img in stringa accettata dal database ,validarla e salvarla
      imgConverter($request, $apartment);

      $apartment -> save();

      // VALIDAZIONE DEI SERVIZI E RELAZIONARLI ALL'APPARTAMENTO
      if (!array_key_exists('services',$validatedData)) {
        $apartment -> services() -> sync([]);
      }else {
        $apartment -> services() -> sync($validatedData['services']);
      }

      return redirect() -> route('user')
      -> with("status","Appartamento aggiunto con successo");
    }else {
      return redirect() -> route('home');
    }

    }

  public function edit($id) {
    $apartment = Apartment::findOrFail($id);
    $services = Service::all();
    $userId = Auth::user()->id;
    if ($apartment['user_id'] == $userId) {
      return view('edit', compact('apartment', 'services'));
    } else {
      return redirect() -> back();
    }
  }

  //Funzione per la rotta update
  public function update(Request $request, $id) {
    if (checkPost($request)) {
      $validatedData = $request->validate([
        "name" => "required|string",
        "description" => "required|string",
        "rooms" => "required|integer|min:1|max:50",
        "beds" => "required|integer|min:1|max:50",
        "bathrooms" => "required|integer|min:1|max:50",
        "size" => "required|numeric",
        "address" => "required|string",
        "picture" => "image|mimes:jpeg,bmp,png,jpg|max:5000",
        "services" => "nullable|array",
        "show" => "required|boolean"
      ]);

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
      $apartment -> latitude = getGeocode("lat", $validatedData);
      $apartment -> longitude = getGeocode("lng", $validatedData);
      $apartment -> show = $validatedData['show'];

      if (array_key_exists('picture', $validatedData)) {
        //Se l'utente decide di cambiare l'immagine, la riconverto e la salvo in database
        imgConverter($request, $apartment);
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

    }else {
      return redirect() -> route('home');
    }

    }

  //Funzione per la rotta search
  public function search(Request $request) {

    if (checkPost($request)) {
      $validatedData = $request->validate([
        'address' => 'required|string',
        'radius' => 'required|integer',
        'rooms' => 'required|integer',
        'beds' => 'required|integer',
        'services' => 'array'
      ]);
      //Se dall'input arriva un indirizzo valido
      if(getGeocode("status",$validatedData) == 'OK') {

        $lat = getGeocode("lat", $validatedData);
        $lng = getGeocode("lng", $validatedData);
        $distance = $validatedData['radius'];

        $query = Apartment::getByDistance($lat, $lng, $distance);

        //Se non si trova un appartamento nella zona ricercata
        if(empty($query)) {
          return redirect()->route('home')->withErrors(['Nessun appartamento trovato']);
        }

        $ids = [];

        //Extract the id's
        foreach($query as $apartment) {
          array_push($ids, $apartment->id);
        }

        // richiamo la funzione filtro e salvo il risultato
        $apartments = self::filter($ids, $validatedData);
        $sponsored_id = [];
        foreach ($apartments as $apartment) {
          // ci ricaviamo gli id degli appartamenti filtrati con sponsorships attive
          $sponsorship = $apartment -> sponsorships() -> where('apartment_sponsorship.end_sponsorship', '>', now()) ->get();
          if(count($sponsorship)) {
            $apt_id = $sponsorship[0]->pivot->apartment_id;
            $sponsored_id[] = $apt_id;
          }
        }
        // ci ricaviamo gli appartamenti corrispondenti agli id sponsorizzati
        $sponsored_apts = [];
        foreach ($sponsored_id as $id) {
          $sponsored_apts[] = Apartment::findOrFail($id);
        }

        // eliminiamo i duplicati dagli appartamenti filtrati inizialmente
        $notSponsored_apts = array_diff($apartments, $sponsored_apts);

        if(!count($apartments)) {
          return redirect()->route('home')->withErrors(['Nessun appartamento soddisfa le tue richieste.']);
        } else {
          return view('search', compact('sponsored_apts', 'notSponsored_apts'));
        }
      } else {
        return redirect()->route('home')->withErrors(['Inserisci un indirizzo valido']);
      }

    }else {
      return redirect() -> route('home');
    }

  }

  public function stats($id) {
    $apartment = Apartment::findOrFail($id);

    $days = 7;
    $lastWeekViews = [];
    $lastWeekMsgs = [];
    $date = [];
    $last7days = today()->subDays($days)->toDateString();
    $apartmentViews = $apartment -> views;
    $apartmentMsgs = Message::where('apartment_id', $id)->get();
    // dd($apartmentMsgs);

    for ($i=$days; $i > 0; $i--) {
      $views = $apartmentViews->where('created_at', '<=', today()->subDays($i-2))->where('created_at', '>=', today()->subDays($i-1));
      $msg = $apartmentMsgs->where('created_at', '<=', today()->subDays($i-2))->where('created_at', '>=', today()->subDays($i-1));
      $date[] = now()->subDays($i-1)->format('l');
      $lastWeekViews[] = $views->count();
      $lastWeekMsgs[] = $msg->count();
    }

    $messages = Message::where('apartment_id', $id)->get();

    return view('stats', compact('lastWeekViews', 'lastWeekMsgs', 'date'));
  }

  // FUNZIONE FILTRO PARAMETRI RICERCA
  public function filter($ids, $validatedData) {
    $apartments = [];
    // Pusho dentro apartments gli appartamenti con gli id che ritornano dalla ricerca, gia ordinati per distanza
    foreach ($ids as $id) {
      $apServices = [];
      $apartment = Apartment::findOrFail($id);
      // se l'appartamento è visibile
      if($apartment['show'] == 1) {
        // se il numero di stanze e letti dell'appartamento sono >= a quelli richiesti
        if(($apartment['rooms'] >= $validatedData['rooms']) && ($apartment['beds'] >= $validatedData['beds'])){
          // controlliamo se c'è un filtro sui servizi
          if(array_key_exists('services', $validatedData)) {
            $reqServices = $validatedData['services'];
            foreach ($apartment->services as $service) {
              $apServices[] = $service->id;
            }
            $count = count($reqServices);
            $finalArray = array_intersect($apServices, $reqServices);

            // controllo corrispondenza tra servizi richiesti e servizi dell'appartamento
            if((count($finalArray) == $count)) {
              $apartments[] = $apartment;
            }
          } else {
            $apartments[] = $apartment;
          }
        }
      }
    }
    return $apartments;
  }
}
// Funzione per ottenere lat e lon dall'indirizo passato dall'input
function getGeocode($value, $validatedData){

  $key = "&key=AIzaSyAP3Uq9YyadYgRoX3N_l4rKUN25UD6Zkgo";
  $address = $validatedData['address'];
  $prepAddr = str_replace(' ','+',$address);
  $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr . $key);
  $output= json_decode($geocode);
  $latitude = $output->results[0]->geometry->location->lat;
  $longitude = $output->results[0]->geometry->location->lng;

  switch ($value) {
    case 'lat':
    return $latitude;
    break;
    case 'lng':
    return $longitude;
    break;
    case 'status':
    return $output -> status;
    break;
    default:
    return false;
    break;
  }
}

//VALIDAZIONE DELL'IMAGE CARICATA LATO CLIENT
function imgConverter($request, $apartment){
  $image = $request->file('picture');
  $name = Str::slug($request->input('name')).'_'.time();
  $ext = $image->getClientOriginalExtension();
  $folder = '/uploads/images/';
  $filePath = $folder . $name. '.' . $ext;

  $apartment -> picture = $filePath;

  $image->storeAs($folder, $name.'.'.$ext, "public");
}

//CHECK POST ROUTES

function checkPost($request)
{
  if ($request->method() === 'POST') {
    return true;
  }
}
