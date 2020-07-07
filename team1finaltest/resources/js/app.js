// parte di inclusione di bootstrap e vue.js
require('./bootstrap');

// window.Vue = require('vue');
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// const app = new Vue({
//     el: '#app',
// });

$( document ).ready(function() {

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
  };

 //Slider della searchBar (Raggio KM)
  init();
  function rangeSlider(){
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value;

    slider.oninput = function() {
      output.innerHTML = this.value;
    };
  }

  // Funzione MAPS Google
  var dataAddress = $('.apartmentDetails').data('address');
  console.log(dataAddress);
  var address = dataAddress;
  $.ajax({
  url: "https://api.tomtom.com/search/2/geocode/" + address + ".json",
  data:{
    key: "gvHkFTj7nzPqQoErkvrc7G0bmBdQX4RF",
    limit: 1
  },
  method: "GET",
  success: function(data,stato) {
    const jsonD = data.results;
    if (jsonD.length) {

      for (var i = 0; i < jsonD.length; i++) {
        let obj = jsonD[i];
        var lat = obj.position['lat'];
        var lon = obj.position['lon'];
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


function initMap(lat,lon) {
    // map options
    var options = {
      zoom: 20,
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

})
