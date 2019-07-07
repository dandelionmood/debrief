// Autocompletion in textareas plugins.
const {Textcomplete, Textarea} = require('textcomplete');

/**
 * Autocompletion in textareas
 */
$(function () {

    const _activate_story_autocomplete = function (form_url, textcomplete) {
        // https://github.com/yuku-t/textcomplete/blob/master/doc/getting-started.md
        textcomplete.register([{
            match: /(^|\s)[#](\w*)$/,
            search: function (term, callback) {
                $.getJSON('/' + form_url.match(/(universes\/\d)/)[1] + '/stories/search',
                    {'q': term},
                    function (r) {
                        callback(r);
                    }
                );
            },
            replace: function (value) {
                return '$1[' + value.id + ']';
            },
            template: function (v) {
                return v.label + ' <em>(' + v.id + ')</em>';
            }
        }]);
    };

    const _activate_person_autocomplete = function (form_url, textcomplete) {
        textcomplete.register([{
            match: /(^|\s)[@](\w*)$/,
            search: function (term, callback) {
                $.getJSON('/' + form_url.match(/(universes\/\d)/)[1] + '/people/search',
                    {'q': term},
                    function (r) {
                        callback(r);
                    }
                );
            },
            replace: function (value) {
                return '$1[' + value.id + ']';
            },
            template: function (v) {
                return v.id + (( v.label.length > 0 ) 
                    ? ' <em>(' + v.label + ')</em>' : '');
            }
        }]);
    };

    const _activate_tag_autocomplete = function (form_url, textcomplete) {
        textcomplete.register([{
            match: /(^|\s)[\!](\w*)$/,
            search: function (term, callback) {
                $.getJSON('/' + form_url.match(/(universes\/\d)/)[1] + '/tags/search',
                    {'q': term},
                    function (r) {
                        callback(r);
                    }
                );
            },
            replace: function (value) {
                return '$1[' + value.id + ']';
            },
            template: function (v) {
                return v.label;
            }
        }]);
    };



    $('form textarea.form-control').each(function (i, e) {
        const form = $(e).parents('form:eq(0)');
        const form_url = form.attr('action');
        const editor = new Textarea(e);
        const textcomplete = new Textcomplete(editor);

        // People autocomplete is always active.
        _activate_person_autocomplete(form_url, textcomplete);
        // … As well as tag autocompletion
        _activate_tag_autocomplete(form_url, textcomplete);

        if (form.hasClass('diary')) {
            // Story autocompletion is not supported on diaries
        }
        else if (form.hasClass('wiki')) {
            _activate_story_autocomplete(form_url, textcomplete);
        }

    });
});