
jQuery(document).ready(function($) {
    $('#rr-reservation-form').on('submit', function(e) {
        e.preventDefault();
        $.post(rr_ajax.ajax_url, {
            action: 'rr_make_reservation',
            name: $('input[name="name"]').val(),
            email: $('input[name="email"]').val(),
            phone: $('input[name="phone"]').val(),
            date: $('input[name="date"]').val(),
            time: $('select[name="time"]').val()
        }, function(res) {
            $('#rr-response').text(res.data);
        });
    });
});