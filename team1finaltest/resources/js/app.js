// parte di inclusione di bootstrap e vue.js
require('./bootstrap');

var places = require('places.js');
var placesAutocomplete = places({
  appId: 'pl790YEJF771',
  apiKey: 'd7b6722b1028dec18f077435d29bbe21',
  container: document.querySelector('#address-input')
});

window.Vue = require('vue');
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
const app = new Vue({
    el: '#app',
});
//


$( document ).ready(function() {

  function init(){
    console.log('init');
    rangeSlider();
  };

  init();
  function rangeSlider(){
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value;

      slider.oninput = function() {
      output.innerHTML = this.value;
  };

}
});
