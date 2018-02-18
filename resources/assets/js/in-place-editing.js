/**
 * In place editing (simple label and textarea modification without the need of a full blown form).
 */
jQuery(document).ready(function($) {

    // ctrl-enter on a textarea will submit form
    $('form textarea.form-control').keypress(function (ev) {
        ev = ev.originalEvent;
        const mod = 'ctrl';
        const keycode = (ev.keyCode ? ev.keyCode : ev.which);
        if ((keycode === 13 || keycode === 10) && (!mod || ev[mod + 'Key'])) {
            $(this).parents('form').first().trigger('submit');
        }
    });

    // hide the div and show in-place editing form instead
    const hide_and_show_next_form = function (ev) {
        ev.preventDefault();
        $(this).addClass('hide');
        $(this).next('form:eq(0)').removeClass('hide');
    };
    $('div.hide-and-show-next-form').on('dblclick', hide_and_show_next_form);

});