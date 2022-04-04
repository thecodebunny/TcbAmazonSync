$('#saveAmazonUkItem span').on('click', function(e) {
    e.preventDefault();
    var form = $('#ukAmazonItem')[0];
    var formData = new FormData(form);
    console.log(...formData);
    $.ajax({
        url: $(form).attr('action'),
        type: "POST",
        data: formData,
        processData: false,
        success: function(response) {
            $('#successMsg').show();
            console.log(response);
        },
        error: function(response) {
            $('#nameErrorMsg').text(response);
            $('#emailErrorMsg').text(response);
            $('#mobileErrorMsg').text(response);
            $('#messageErrorMsg').text(response);
        },
    });
});