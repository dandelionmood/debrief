/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');

require('bootstrap');
require('bootstrap-select'); // requires poppers.js under the hood

// I18N
// We need to add localization to moment.js
require('moment/locale/fr.js');
// We need to add localization to bootstrap datepicker
require('bootstrap-datepicker/js/locales/bootstrap-datepicker.fr.js');
// / I18N

$(function () {

    // MOBILE NAVIGATION TOGGLE LINK (SEE universe.blade.php).
    $('#mobileNavToggle').click(function (e) {
        // We hide the link.
        $(this).parents('div:eq(0)')
            .attr('class', 'd-none');
        // We show the real nav menu with a quick slide down effect.
        $('.bd-sidebar > .bd-sidebar-content')
            .hide().attr('class', 'bd-sidebar-content d-block d-lg-none')
            .slideDown('fast');
    });

    // Flashing flash messages (SEE app.blade.php).
    $('.bd-flash-messages > div').slideDown('fast', function () {
        let elm = $(this);
        let chrono_flash = setInterval(function () {
            clearInterval(chrono_flash);
            elm.slideUp('fast');
        }, 5000);
    });

    $('select').selectpicker();

    // We make sure to confirm every delete action … jQuery to the rescue.
    $('form input[name="_method"][value="DELETE"]')
        .parent('form')
        .on('submit', function () {
            return window.confirm(Lang.get('js.are_you_sure_you_want_to_delete'));
        });

});