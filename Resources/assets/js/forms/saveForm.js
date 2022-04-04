$(document).ready(function() {
    $(function() {
        if ($('input.datepicker').length) {
            $('input.datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                defaultDate: +0,
                showAnim: "drop"
            });
        }
    });


    $('#saveAmazonItem').on('click', function(e) {
        e.preventDefault();
        var form = $('#ukAmazonItem')[0];
        var formData = new FormData(form);
        console.log($(form).serialize());
        if ($("input[name = 'height']").val() && !$("select[name = 'height_measure']").val()) {
            alert('You have selected Height, Height Measurement Unit is required!!!');
            return false;
        }
        if ($("input[name = 'weight']").val() && !$("select[name = 'weight_measure']").val()) {
            alert('You have selected Weight, Weight Measurement Unit is required!!!');
            return false;
        }
        if ($("input[name = 'length']").val() && !$("select[name = 'length_measure']").val()) {
            alert('You have selected Length, Length Measurement Unit is required!!!');
            return false;
        }
        if ($("input[name = 'width']").val() && !$("select[name = 'width_measure']").val()) {
            alert('You have selected Width, Width Measurement Unit is required!!!');
            return false;
        }
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
                    console.log(response);
                    if (response.statusmessage == 'SUCCESS') {
                        $('#successModal .modal-content').addClass('bg-gradient-success');
                    } else {
                        $('#successModal .modal-content').addClass('bg-gradient-danger');
                    }
                    $('#successModal .modal-header .modal-title').html(response.heading);
                    $('#successModal .modal-body').html(response.message);
                    $('#successModal').addClass('show');
                    $('#successModal').show('slow');
                    $('body').addClass('modal-open');
                },
                error: function(response) {
                    console.log(response);
                    var message = response.responseJSON.message;
                    $('#successMsgAmazon').html(message).show();
                },
            });
        }
    });

    $('body').on('click', '#updateAmazonItem, #uploadAmazonItem', function(e) {
        e.preventDefault();
        if (confirm('Are you sure? This will create new ASIN or overwrite the data that is currently online. OTHER THAN IMAGES.')) {
            var comp = $("input[name = 'company_id']").val();
            var id = $("input[name = 'id']").val();
            var url = 'https://go.zoomyo.com/' + comp + '/tcb-amazon-sync/item/update-online/' + id;
            $.ajax({
                url: $(this).data('url'),
                type: "GET",
                processData: false,
                cache: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 500) {
                        alert(response.responseText);
                    } else {
                        $('#successMsgAmazon').show();
                    }
                    console.log(response);
                },
                error: function(response) {
                    console.log(response);
                    var message = response.responseJSON.message;
                    $('#successMsgAmazon').html(message).show();
                },
            });
        }
    });

    $('#brandFormButton').on('click', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var form = $('#brandForm')[0];
        var formData = new FormData(form);
        console.log($(form).serialize());
        $.ajax({
            url: $(this).data('action'),
            type: "POST",
            data: formData ? formData : $(form).serialize(),
            processData: false,
            cache: false,
            contentType: false,
            success: function(response) {
                if (response.status == 500) {
                    alert(response.responseText);
                } else {
                    $('.brandMessage').html(response.message);
                    $('.brandMessage').show();
                }
                console.log(response);
            },
            error: function(response) {
                console.log(response);
                var message = response.responseJSON.message;
                $('#successMsgAmazon').html(message).show();
            },
        });
    });
});