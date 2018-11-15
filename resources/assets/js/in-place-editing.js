const autosize = require('autosize');

/**
 * In place editing (simple label and textarea modification without the need of a full blown form).
 */
$(function () {

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
        let form = $(this).next('form:eq(0)');
        form.removeClass('hide');

        // automatically resize the textarea height
        autosize(form.find('textarea.form-control'));
    };
    $('div.hide-and-show-next-form').on('dblclick taphold', hide_and_show_next_form);

});