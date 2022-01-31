if ($(".tcb-checkbox").checked == true) {
    $(".tcb-checkbox").value = "on";
} else {
    $(".tcb-checkbox").value = null;
}

$(".tcb-checkbox").on("change", function() {
    if (this.checked == true) {
        this.value = "on";
    } else {
        this.value = null;
    }
});

$(".tcb-switch").on("change", function() {
    if (this.checked == true) {
        this.value = 1;
    } else {
        this.value = 0;
    }
});

$(".tcb-select").on("change", function() {
    console.log(this.value);
    $(this).attr("value", this.value);
    $(this).attr("selected", "selected");
});

$(".tcb-checkbox").on("change", function() {
    if (this.checked == true) {
        this.value = "on";
    } else {
        this.value = null;
    }
});

$(".tcb-checkbox-label").on("click", function() {
    var checkbox = $(this).closest(".col-md-6").find("input");
    console.log(checkbox[0].value);
    if (checkbox[0].checked == true) {
        checkbox[0].value = "";
        checkbox[0].checked = false;
    } else {
        checkbox[0].value = "on";
        checkbox[0].checked = true;
    }
});

$("#mainPic, #pic1, #pic2, #pic3, #pic4, #pic5, #pic6").fileinput();

$("#thefiles").on("change", function() {
    var fileInput = $(this);
    console.log(fileInput[0].value);
});

$("#updateAmazonStock").on("click", function() {
    if (confirm('Are you sure? This will change product quantity on Amazon')) {
        var comp = $("input[name = 'company_id']").val();
        var country = $("input[name = 'country']").val();
        var id = $("input[name = 'id']").val();
        var qty = $("input[name = 'quantity']").val();
        var url = 'https://go.zoomyo.com/' + comp + '/tcb-amazon-sync/amazon-updatestock/' + country + '/' + id + '/' + qty;
        console.log(url);
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                $('#successMsg').show();
                console.log(response);
            },
            error: function(response) {
                console.log(response);
            },
        });
    }
});

$("#updateAmazonTitle").on("click", function() {
    if (confirm('Are you sure? This will change product title on Amazon')) {
        var comp = $("input[name = 'company_id']").val();
        var country = $("input[name = 'country']").val();
        var id = $("input[name = 'id']").val();
        var title = $("input[name = 'title']").val();
        var url = 'https://go.zoomyo.com/' + comp + '/tcb-amazon-sync/amazon-updatetitle/' + country + '/' + id + '/' + title;
        console.log(url);
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                $('#successMsg').show();
                console.log(response);
            },
            error: function(response) {
                console.log(response);
            },
        });
    }
});

$("#updateAmazonPrice").on("click", function() {
    if (confirm('Are you sure? This will change the product price on Amazon')) {
        var comp = $("input[name = 'company_id']").val();
        var country = $("input[name = 'country']").val();
        var id = $("input[name = 'id']").val();
        var price = $("input[name = 'price']").val();
        var url = 'https://go.zoomyo.com/' + comp + '/tcb-amazon-sync/amazon-updateprice/' + country + '/' + id + '/' + price + '/' + company_currency_code;
        console.log(company_currency_code);
        if (!price || price == '') {
            alert('Price is required!!!');
            return false;
        }
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                $('#successMsg').show();
                console.log(response);
            },
            error: function(response) {
                console.log(response);
            },
        });
    }
});

$("#updateAmazonSalePrice").on("click", function() {
    if (confirm('Are you sure? This will change the product sale price on Amazon')) {
        var comp = $("input[name = 'company_id']").val();
        var country = $("input[name = 'country']").val();
        var id = $("input[name = 'id']").val();
        var saleprice = $("input[name = 'sale_price']").val();
        var startdate = $("input[name = 'sale_start_date']").val();
        var enddate = $("input[name = 'sale_end_date']").val();
        var url = 'https://go.zoomyo.com/' + comp + '/tcb-amazon-sync/amazon-updatesaleprice/' + country + '/' + id + '/' + startdate + '/' + enddate + '/' + saleprice + '/' + company_currency_code;
        console.log(url);
        if (!saleprice || saleprice == '') {
            alert('Sale Price is required!!!');
            return false;
        }
        if (!startdate || startdate == '') {
            alert('Sale Start Date is required!!!');
            return false;
        }
        if (!enddate || enddate == '') {
            alert('Sale End Date is required!!!');
            return false;
        }
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                $('#successMsg').show();
                console.log(response);
            },
            error: function(response) {
                console.log(response);
            },
        });

    }
});