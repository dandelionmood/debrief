require('./bootstrap');

$(document).ready(function () {

    // ctrl-enter on a textarea
    $('form textarea.form-control').keypress(function (ev) {
        ev = ev.originalEvent;
        const mod = 'ctrl';
        const keycode = (ev.keyCode ? ev.keyCode : ev.which);
        if ((keycode === 13 || keycode === 10) && (!mod || ev[mod + 'Key'])) {
            $(this).parents('form').first().trigger('submit');
        }
    });

    // in-place editing
    const hide_and_show_next_form = function (ev) {
        ev.preventDefault();
        $(this).addClass('hide');
        $(this).next('form:eq(0)').removeClass('hide');
    };
    $('div.hide-and-show-next-form').on('dblclick', hide_and_show_next_form);
    $('a.hide-and-show-next-form').on('click', hide_and_show_next_form);



    const { Textcomplete, Textarea } = require('textcomplete');
    $('form textarea.form-control').each(function(i, e) {

        const form_url = $(e).parents('form:eq(0)').attr('action');
        const search_url = '/' + form_url.match(/(universes\/\d)/)[1] + '/search';

        const editor = new Textarea(e);
        const textcomplete = new Textcomplete(editor);

        // https://github.com/yuku-t/textcomplete/blob/master/doc/getting-started.md
        textcomplete.register([{
            match: /(^|\s)[#@](\w*)$/,
            search: function (term, callback) {
                jQuery.getJSON(search_url, {'q': term}, function(r) {
                    callback(r);
                });
            },
            replace: function (value) {
                return '$1[' + value.id + ']';
            },
            template: function(v) {
                return v.label + ' <em>(' + v.id + ')</em>';
            }
        }]);

    });

});

