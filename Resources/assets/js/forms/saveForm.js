$(function() {
    $('input.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true,
        defaultDate: +0,
        showAnim: "drop"
    });
});


$('#saveAmazonItem').on('click', function(e) {
    e.preventDefault();
    var form = $('#ukAmazonItem')[0];
    var formData = new FormData(form);
    console.log($(form).serialize());
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': formData.get('_token')
        }
    });
    $.ajax({
        url: $(form).attr('action'),
        type: "POST",
        data: formData ? formData : $(form).serialize(),
        processData: false,
        cache: false,
        contentType: false,
        success: function(response) {
            $('#successMsg').show();
            console.log(response);
        },
        error: function(response) {
            console.log(response);
            $('#nameErrorMsg').text(response);
            $('#emailErrorMsg').text(response);
            $('#mobileErrorMsg').text(response);
            $('#messageErrorMsg').text(response);
        },
    });
});

$('#fetchAmazonItem').on('click', function(e) {
    e.preventDefault();
    if (confirm('Are you sure? This will overwrite the data saved in Database.')) {
        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            processData: false,
            cache: false,
            contentType: false,
            success: function(response) {
                $('#successMsgAmazon').show();
                console.log(response);
            },
            error: function(response) {
                console.log(response);
                $('#nameErrorMsg').text(response);
                $('#emailErrorMsg').text(response);
                $('#mobileErrorMsg').text(response);
                $('#messageErrorMsg').text(response);
            },
        });
    }
});