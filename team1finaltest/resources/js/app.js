require('./bootstrap');

// window.Vue = require('vue');
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// const app = new Vue({
//     el: '#app',
// });


function start(){

  const location = window.location.href;
  // Funzione della searchBar e slider
  init();
  // Funzione che fa apparire il bottone per la search allo scroll della pagina
  scrollNav();
  // Chiude la searchbar a comparsa
  chiudiNav();
  // Ricerca avanzata
  ricercaAvanzata();
  // **
  ricercaAvanzata2();

  // Se siamo nella pagine delle statistiche, parte la funzione Ajax per i grafici Chart.js
  if (location.includes('stats/')) {
    getStats();
  }
  // Controller per la navBar, comparsa/scomparsa menu'
  navToggle();

  $(document).click( function(event){

    var viewportWidth = $(window).width();
    if ( (viewportWidth < 850) && $('.burger-box').is(':visible') )  {
      if (!$(event.target).is('.burger')) {
        $('.burger-box').hide();
      }
    }
    if ( $('.drop-menu').is(':visible') && (!$(event.target).closest('.mynav-menu').length) ) {
      $('.drop-menu').hide();
    }
  } );
  // -------

  if (location.includes('show/')) {
    getMap();
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
      var screenWdth = $(window).width();
      if ($(this).scrollTop()>190)
      {
        $('.navSearch').fadeIn(1000);

        if (screenWdth <= 850) {
          $('.burger').show();

        }
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
    $(".burger").hide();
  });
}

// x per chiudere la schermata di ricerca allargata nav
function chiudiNav(){
  $(".closeSearch").on("click", function(){
    $(".apriSearch").fadeOut(1000);
    var screenWdth = $(window).width();
    if (screenWdth <= 850) {

      $('.burger').show();
    }

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

// Funzione MAPS Google
function getMap() {
  const location = window.location.href;

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

function getStats() {
  var id = $('.statsContainer').data('id');
  $.ajax({
    url: '/getStats/' + id,
    method: "GET",
    success: function(data, stato) {
      // ChartJS
      var ctx = document.getElementById('views').getContext('2d');
      var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
          labels: data.date,
          datasets: [{
            label: 'Visualizzazioni settimana',
            backgroundColor: '#FF385C',
            borderColor: '#FF385C',
            data: data.lastWeekViews
          }]
        },

        // Configuration options go here
        options: {
          responsive: true,
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true,
                precision: 0
              }
            }]
          }
        }
      });

      var ctx = document.getElementById('msgs').getContext('2d');
      var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
          labels: data.date,
          datasets: [{
            label: 'Messaggi settimana',
            backgroundColor: '#FF385C',
            borderColor: '#FF385C',
            data: data.lastWeekMsgs
          }]
        },

        // Configuration options go here
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true,
                precision: 0
              }
            }]
          }
        }
      });
    },
    error: function(richiesta, stato, errore) {
      console.error("ERRORE!");
    }
  });
}

function navController(event) {

}

function navToggle() {
  $('.mynav-menu').click(function () {
    $('.drop-menu').toggle();
  })

  $('.burger').click(function () {
    $('.burger-box').toggle();
  })
}

$( document ).ready(start);
