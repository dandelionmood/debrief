require('bootstrap-datepicker');

let moment = require('moment');

$(function () {

    // we startup the datepicker plugin
    let dp = $('.bootstrap-datepicker').datepicker({
        'calendarWeeks': true,
        'language': Lang.locale()
    });

    // we update the selected date if it has been specified
    let selected_date = dp.data('current-node');
    if (typeof selected_date !== 'undefined') {
        dp.datepicker('update', moment(selected_date).toDate());
    }

    // on date change, we automatically go to the corresponding page
    dp.on('changeDate', function (e) {
        location.href = dp.data('story-base-url')
            + '/' + moment(e.date).format('YYYY-MM-DD');
    });

});