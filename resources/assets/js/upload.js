const Dropzone = require('dropzone');

jQuery(document).ready(function ($) {

    // These extensions will be use to insert specific markdown markup
    // for images.
    const extensions_image = ['gif', 'jpg', 'jpeg', 'png'];

    // We need to get the token value to prevent XSS errors from Laravel.
    const token = $('input[name="_token"]:eq(0)').val();

    // Every textarea will allow files to be dropped onto.
    $('textarea').each(function () {

        const textarea = $(this);

        // Defined in the layout template.
        if (typeof URL_FILE_UPLOAD === 'undefined') {
            console.error("_URL_FILE_UPLOAD must be defined for file upload to work properly.");
            return false;
        }

        // **An ID is required for each textarea by dropzone**
        let id = $(this).attr('id');
        // We generate it if necessary and update the textarea DOM element accordingly
        if (!id) { id = 'elm_' + Math.random().toString(36).substr(2, 10); textarea.attr('id', id); }

        // Hint label that will allow for files to be uploaded with a selection box (compulsory for mobile use).
        let manual_upload_link = $("<a><span class='oi oi-data-transfer-upload' title='upload' aria-hidden='true'></span>"
            + " Drop any file you want to upload, or click here.</a>")
            .addClass('d-block d-sm-none ')
            .css({"display": "block", "margin-top": ".2rem"})
            .attr("href", "javascript:void(0)");
        textarea.after(manual_upload_link);
        textarea.focus(function () { manual_upload_link.removeClass("d-block d-sm-none"); });
        textarea.blur(function () {
            // We allow for a few moments for the click on link to bubble before hiding it.
            let chrono = setInterval(function () {
                clearInterval(chrono);
                manual_upload_link.addClass("d-block d-sm-none");
            }, 500);
        });
        textarea.trigger('blur');

        // Dropzone instanciation !
        // Cf. http://www.dropzonejs.com/#configuration-options
        new Dropzone('#' + id, {
            "paramName": "file",
            "url": URL_FILE_UPLOAD,
            "clickable": manual_upload_link[0],
            "autoProcessQueue": true,
            "uploadMultiple": false,
            "params": {"_token": token},
        }).on("success", function (file, server) {
            _insert_in_textarea(textarea,
                // We use the extension of the uploaded file to differentiate a standard link from an image
                // when formating the string that will be added to the textarea.
                ((extensions_image.indexOf(server.extension) > -1) ? '!' : '')
                    + "[" + server.fileName + "](" + server.path + ")"
            );
        });

    });

    /**
     * Method to allow insertion into the textarea element right where the cursor is !
     * Derived from https://stackoverflow.com/questions/11076975/insert-text-into-textarea-at-cursor-position-javascript
     * @param elm DOM element of the textarea
     * @param string_to_insert
     * @private
     * @void
     */
    function _insert_in_textarea(elm, string_to_insert) {
        const cursorPosStart = elm.prop('selectionStart'),
            cursorPosEnd = elm.prop('selectionEnd'),
            v = elm.val(),
            textBefore = v.substring(0, cursorPosStart),
            textAfter = v.substring(cursorPosEnd, v.length);
        elm.val(textBefore + string_to_insert + textAfter);
    }

});