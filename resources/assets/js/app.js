/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//    el: '#app'
// });

$.fn.enterKey = function (fnc, mod) {
    return this.each(function () {
        $(this)
    })
};

$(document).ready(function () {
    $('form textarea.form-control').keypress(function (ev) {
        ev = ev.originalEvent;
        let mod = 'ctrl';
        let keycode = (ev.keyCode ? ev.keyCode : ev.which);
        if ((keycode === 13 || keycode === 10) && (!mod || ev[mod + 'Key'])) {
            $(this).parents('form').first().trigger('submit');
        }
    });
});
