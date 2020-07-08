require('./bootstrap');

// window.Vue = require('vue');
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// const app = new Vue({
//     el: '#app',
// });


function start(){

    init();

    // Funzione MAPS Google
    const location = window.location.href;
    if (location.includes('show/')) {
      var dataAddress = $('.apartmentDetails').data('address');
      var address = dataAddress.replace(' ','+');
      console.log('address',address);
      $.ajax({
        url: "https://maps.googleapis.com/maps/api/geocode/json",
        data:{
          key: "AIzaSyAP3Uq9YyadYgRoX3N_l4rKUN25UD6Zkgo",
          address: address,
          limit: 1
        },
        method: "GET",
        success: function(data,stato) {
          console.log(data);
          const jsonD = data.results;
          if (jsonD.length) {
            for (var i = 0; i < jsonD.length; i++) {
              let obj = jsonD[i];
              var lat = obj.geometry.location['lat'];
              var lon = obj.geometry.location['lng'];
              console.log('lat: ',lat);
              console.log('lon: ',lon);
            }
            initMap(lat,lon)
          }else {
            $('#map').html('<h2> Nessun riferimento geografico trovato</h2>')
          }

        },
        error: function(richiesta,stato,errore){
          alert("Chiamata fallita!!!");
        }
      });
    }



}

  // Algolia autocomplete script
  function init(){
    if ($('.searchBar').length) {
      rangeSlider();
    }
    if ($('#address-input').length) {
      var places = require('places.js');
      var placesAutocomplete = places({
        appId: 'pl790YEJF771',
        apiKey: 'd7b6722b1028dec18f077435d29bbe21',
        container: document.querySelector('#address-input')
      });
    }
      ricercaAvanzata();
  };

  // funzione mostra e nascondi ricerca avanzata
    function ricercaAvanzata(){
      $("#ricercaAvanzata").click(function(){
      $("#containerRicercaAvanzata").fadeToggle("slow");
      });
    }

  //Slider della searchBar (Raggio KM)

  function rangeSlider(){
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value;

    slider.oninput = function() {
      output.innerHTML = this.value;
    };
  }

  function initMap(lat,lon) {
    // map options
    var options = {
      zoom: 15,
      center: {lat: lat,
        lng: lon
      }
    }

    // new map
    var map = new google.maps.Map(document.getElementById('map'), options);

    //add markers
    var marker = new google.maps.Marker({
      position:{lat: lat, lng: lon},
      map: map
    });
  }


$( document ).ready(start);
