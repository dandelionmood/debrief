require('bootstrap-datepicker');
let moment = require('moment');
const Dropzone = require('dropzone');

$(function () {

    // These extensions will be use to insert specific markdown markup
    // for images.
    const extensions_image = ['gif', 'jpg', 'jpeg', 'png'];

    // We need to get the token value to prevent XSS errors from Laravel.
    const token = $('input[name="_token"]:eq(0)').val();

    // Every textarea will allow files to be dropped onto.
    $('textarea').each(function () {

        const textarea = $(this);
        const form = textarea.parents('form:eq(0)');

        // We add the toolbar in which every function will go.
        const toolbar = $('<div class="toolbar"></div>');
        textarea.after(toolbar);

        // DATE PICKER (only on diaries)
        if (form.hasClass('diary')) {
            dateInsert(textarea, toolbar);
        }

        // FILE UPLOAD
        fileUpload(textarea, toolbar);

    });

    function dateInsert(textarea, toolbar) {
        let date_insert_link = $("<a><span class='oi oi-calendar' title='calendar' aria-hidden='true'></span>"
            + "Insert a date</a>")
            .attr("href", "javascript:void(0)")
            .datepicker({
                'calendarWeeks': true,
                'autoclose': true,
            }).on('changeDate', function (e) {
                textarea.trigger('focus');
                textarea[0].insertAtCaret('[' + moment(e.date).format('YYYY-MM-DD') + ']');
            });

        toolbar.append(date_insert_link);
    }

    function fileUpload(textarea, toolbar) {
        // Defined in the layout template.
        if (typeof URL_FILE_UPLOAD === 'undefined') {
            console.error("_URL_FILE_UPLOAD must be defined for file upload to work properly.");
            return false;
        }

        // **An ID is required for each textarea by dropzone**
        let id = $(this).attr('id');
        // We generate it if necessary and update the textarea DOM element accordingly
        if (!id) {
            id = 'elm_' + Math.random().toString(36).substr(2, 10);
            textarea.attr('id', id);
        }

        // Hint label that will allow for files to be uploaded with a selection box (compulsory for mobile use).
        let manual_upload_link = $("<a><span class='oi oi-data-transfer-upload' title='upload' aria-hidden='true'></span>"
            + " Drop any file you want to upload, or click here.</a>")
            .attr("href", "javascript:void(0)");

        toolbar.append(manual_upload_link);

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
            textarea.trigger('focus');
            textarea[0].insertAtCaret(
                // We use the extension of the uploaded file to differentiate a standard link from an image
                // when formating the string that will be added to the textarea.
                ((extensions_image.indexOf(server.extension) > -1) ? '!' : '')
                + "[" + server.fileName + "](" + server.path + ")"
            );

        });

    }
});

/**
 * Very simple function to insert a string where the caret currently
 * is on a textarea.
 *
 * Found here : https://stackoverflow.com/questions/11076975/insert-text-into-textarea-at-cursor-position-javascript
 * @param text string to insert
 */
HTMLTextAreaElement.prototype.insertAtCaret = function (text) {
    text = text || '';
    if (document.selection) {
        // IE
        this.focus();
        let sel = document.selection.createRange();
        sel.text = text;
    } else if (this.selectionStart || this.selectionStart === 0) {
        // Others
        let startPos = this.selectionStart;
        let endPos = this.selectionEnd;
        this.value = this.value.substring(0, startPos) +
            text +
            this.value.substring(endPos, this.value.length);
        this.selectionStart = startPos + text.length;
        this.selectionEnd = startPos + text.length;
    } else {
        this.value += text;
    }
};