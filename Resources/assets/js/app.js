$("#sidenav-main").addClass("sidebar");
var base_host = window.location.host;
$('link[rel=stylesheet][href*="argon.css"]').attr('href', '//modules/TcbAmazonSync/Resources/assets/argon/css/argon.css?v=1.7.5');
$('link[rel=stylesheet][href*="custom.css"]').remove();
$('link[rel=stylesheet][href*="akaunting-color.css"]').remove();
$('#amazonTab a').on('click', function(e) {
    e.preventDefault();
    $(this).tab('show');
    console.log($(this));
});

console.log($("#deleteWarehouse"));

$("body").on('click', "#deleteWarehouse", function() {
    var url = $(this).attr('route');
    console.log(url);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        type: "POST",
        processData: false,
        cache: false,
        contentType: false,
        success: function(response) {
            console.log(response);
            alert(response.message);
            $(this).closest("tr").remove();
        },
        error: function(response) {
            alert(response.message);
        },
    });
});