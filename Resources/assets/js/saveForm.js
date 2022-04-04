$('#saveAmazonUkItem span').on('click', function(e) {
    e.preventDefault();
    console.log($('#ukAmazonItem').serialize());
});