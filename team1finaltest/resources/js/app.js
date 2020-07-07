// parte di inclusione di bootstrap e vue.js
require('./bootstrap');
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
