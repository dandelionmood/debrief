/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');

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

});