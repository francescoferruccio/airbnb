require('./bootstrap');

// window.Vue = require('vue');
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// const app = new Vue({
//     el: '#app',
// });


function start(){

    init();

    scrollNav();

    chiudiNav();

    ricercaAvanzata();

    ricercaAvanzata2();

    $('.caret').click(function () {
      $('.drop-menu').toggle();
    })

    $('.burger').click(function () {
      $('.burger-box').toggle();
    })


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

  function init(){
    // Algolia autocomplete script
    if ($('.searchBar').length) {

        switch (window.location.pathname) {
          case '/':
          rangeSlider('myRange', 'demo');
          rangeSlider('myRange2', 'demo2');
            break;
          default:
          rangeSlider('myRange2', 'demo2');
        }
    }
    if ($('#address-input').length) {
      var places = require('places.js');
      var placesAutocomplete = places({
        appId: 'pl790YEJF771',
        apiKey: 'd7b6722b1028dec18f077435d29bbe21',
        container: document.querySelector('#address-input')
      });
    }
    if ($('#address-input2').length) {
      var places = require('places.js');
      var placesAutocomplete = places({
        appId: 'pl790YEJF771',
        apiKey: 'd7b6722b1028dec18f077435d29bbe21',
        container: document.querySelector('#address-input2')
      });
    }
  };

  // funzione mostra searchbar nav sullo scroll

  function scrollNav(){
    $('.navSearch').hide();
    const wlocation = location.pathname;

    if (wlocation == '/search' || wlocation.includes('/show')) {
      $('.navSearch').show();
    } else {
      $(window).scroll(function() {
        if ($(this).scrollTop()>190)
        {
          $('.navSearch').fadeIn(1000);
        }
        else
        {
          $('.navSearch').fadeOut(300);
          $(".apriSearch").hide();
        }
      });
    }
    $("#stileNavSearch").click(function(){
      event.preventDefault();
      $(".apriSearch").slideDown();
    });
  }

  // x per chiudere la schermata di ricerca allargata nav
  function chiudiNav(){
    $(".closeSearch").on("click", function(){
      $(".apriSearch").fadeOut(1000);
    });
  }


  // funzione mostra e nascondi ricerca avanzata
    function ricercaAvanzata(){
      $("#ricercaAvanzata").click(function(){
      $("#containerRicercaAvanzata").fadeToggle("slow");
      });
    }

    function ricercaAvanzata2(){
      $("#ricercaAvanzata2").click(function(){
      $("#containerRicercaAvanzata2").fadeToggle("slow");
      });
    }

  //Slider della searchBar (Raggio KM)

  function rangeSlider(idRange, idSpan){
    var slider = document.getElementById(idRange);
    var output = document.getElementById(idSpan);

    output.innerHTML = slider.value;

    slider.oninput = function() {
      output.innerHTML = this.value;
    }

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
