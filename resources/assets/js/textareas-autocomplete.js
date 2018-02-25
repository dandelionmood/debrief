// Autocompletion in textareas plugins.
const {Textcomplete, Textarea} = require('textcomplete');

/**
 * Autocompletion in textareas
 */
jQuery(document).ready(function ($) {
    $('form textarea.form-control').each(function (i, e) {

        const form_url = $(e).parents('form:eq(0)').attr('action');
        const search_url = '/' + form_url.match(/(universes\/\d)/)[1] + '/search';

        const editor = new Textarea(e);
        const textcomplete = new Textcomplete(editor);

        // https://github.com/yuku-t/textcomplete/blob/master/doc/getting-started.md
        textcomplete.register([{
            match: /(^|\s)[#](\w*)$/,
            search: function (term, callback) {
                jQuery.getJSON(search_url, {'q': term}, function (r) {
                    callback(r);
                });
            },
            replace: function (value) {
                return '$1[' + value.id + ']';
            },
            template: function (v) {
                return v.label + ' <em>(' + v.id + ')</em>';
            }
        }]);

    });
});