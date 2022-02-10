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
        $(this).attr("checked", true);
    } else {
        this.value = 0;
        $(this).attr("checked", false);
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

$("#updateAmazonBulletPoints").on("click", function() {
    if (confirm('Have you saved new Bullet Points?')) {
        if (confirm(' Are you sure? This will change product bulletpoints on Amazon.')) {
            var comp = $("input[name = 'company_id']").val();
            var country = $("input[name = 'country']").val();
            var id = $("input[name = 'id']").val();
            var url = 'https://go.zoomyo.com/' + comp + '/tcb-amazon-sync/amazon-updatebulletpoints/' + id;
            console.log(url);
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    console.log(response.message);
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
                    console.log(response.message);
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
            });
        }
    }
});

$("#updateAmazonImages").on("click", function() {
    if (confirm('Have you saved new Images?')) {
        if (confirm(' Are you sure? This will change product Images on Amazon.')) {
            $('#successModal .modal-header .modal-title').html('In Process');
            $('#successModal .modal-body').html('This process will take some time. Please stay on this page and do not close the tab/browser.');
            $('#successModal').addClass('show');
            $('#successModal').show('slow');
            $('body').addClass('modal-open');
            var comp = $("input[name = 'company_id']").val();
            var country = $("input[name = 'country']").val();
            var id = $("input[name = 'id']").val();
            var url = 'https://go.zoomyo.com/' + comp + '/tcb-amazon-sync/amazon-updateimages/' + id;
            console.log(url);
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    console.log(response.message);
                    $('#successModal .modal-content').addClass('bg-gradient-danger');
                    $('#successModal .modal-header .modal-title').html(response.heading);
                    $('#successModal .modal-body').html(response.message);
                    $('#successModal').addClass('show');
                    $('#successModal').show('slow');
                    $('body').addClass('modal-open');
                },
                error: function(response) {
                    console.log(response.message);
                    $('#successModal .modal-content').addClass('bg-gradient-danger');
                    $('#successModal .modal-header .modal-title').html(response.heading);
                    $('#successModal .modal-body').html(response.message);
                    $('#successModal').addClass('show');
                    $('#successModal').show('slow');
                    $('body').addClass('modal-open');
                },
            });
        }
    }
});

$("#updateAmazonDescription").on("click", function() {
    if (confirm('Have you saved new Description?')) {
        if (confirm(' Are you sure? This will change product Description on Amazon.')) {
            var comp = $("input[name = 'company_id']").val();
            var country = $("input[name = 'country']").val();
            var id = $("input[name = 'id']").val();
            var url = 'https://go.zoomyo.com/' + comp + '/tcb-amazon-sync/amazon-updatedescription/' + id;
            console.log(url);
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    console.log(response.message);
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
                    console.log(response.message);
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
            });
        }
    }
});

$("#updateAmazonKeywords").on("click", function() {
    if (confirm('Have you saved new Keywords?')) {
        if (confirm(' Are you sure? This will change product Keywords on Amazon.')) {
            var comp = $("input[name = 'company_id']").val();
            var country = $("input[name = 'country']").val();
            var id = $("input[name = 'id']").val();
            var url = 'https://go.zoomyo.com/' + comp + '/tcb-amazon-sync/amazon-updatekeywords/' + id;
            console.log(url);
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    console.log(response.message);
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
                    console.log(response.message);
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
            });
        }
    }
});

$("#updateAmazonCategory").on("click", function() {
    if (confirm('Are you sure? This will change product category on Amazon')) {
        var comp = $("input[name = 'company_id']").val();
        var country = $("input[name = 'country']").val();
        var id = $("input[name = 'id']").val();
        var cat = $("input[name = 'category_id']").val();
        var url = 'https://go.zoomyo.com/' + comp + '/tcb-amazon-sync/amazon-updatecategory/' + id + '/' + cat;
        console.log(url);
        $.ajax({
            url: url,
            type: "GET",
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
        });
    }
});

$("#updateAmazonStock").on("click", function() {
    if (confirm('Are you sure? This will change product quantity on Amazon')) {
        var comp = $("input[name = 'company_id']").val();
        var country = $("input[name = 'country']").val();
        var id = $("input[name = 'id']").val();
        var qty = $("input[name = 'quantity']").val();
        var url = 'https://go.zoomyo.com/' + comp + '/tcb-amazon-sync/amazon-updatestock/' + id + '/' + qty;
        console.log(url);
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
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
        var url = 'https://go.zoomyo.com/' + comp + '/tcb-amazon-sync/amazon-updatetitle/' + id + '/' + title;
        console.log(url);
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
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
        var id = $("input[name = 'id']").val();
        var price = $("input[name = 'price']").val();
        var currency = $("input[name = 'currency_code']").val();
        var url = 'https://go.zoomyo.com/' + comp + '/tcb-amazon-sync/amazon-updateprice/' + id + '/' + price + '/' + currency;
        if (!price || price == '') {
            alert('Price is required!!!');
            return false;
        }
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
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
        var id = $("input[name = 'id']").val();
        var saleprice = $("input[name = 'sale_price']").val();
        var startdate = $("input[name = 'sale_start_date']").val();
        var enddate = $("input[name = 'sale_end_date']").val();
        var currency = $("input[name = 'currency_code']").val();
        var url = 'https://go.zoomyo.com/' + comp + '/tcb-amazon-sync/amazon-updatesaleprice/' + id + '/' + startdate + '/' + enddate + '/' + saleprice + '/' + currency;
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
                console.log(response);
            },
            error: function(response) {
                console.log(response);
            },
        });

    }
});

/**
 * Shipping & Orders API
 */

// Confirm Shipment
$("#confirmAmazonShipment").on("click", function() {
    if (confirm('Are you sure? This will confirm the shipment for this order on Amazon')) {
        var comp = $("input[name = 'company_id']").val();
        var country = $("input[name = 'country']").val();
        var carrier = $("select[name = 'carrier']").val();
        var id = $("input[name = 'id']").val();
        var amzOrderId = $("input[name = 'amzOrderId']").val();
        var tId = $("input[name = 'tId']").val();
        var tId2 = $("input[name = 'tId2']").val();
        var tId3 = $("input[name = 'tId3']").val();
        var tId4 = $("input[name = 'tId4']").val();
        var tId5 = $("input[name = 'tId5']").val();
        if (tId2 == '') {
            tId2 = null;
        }
        if (tId3 == '') {
            tId3 = null;
        }
        if (tId4 == '') {
            tId4 = null;
        }
        if (tId5 == '') {
            tId5 = null;
        }
        var url = 'https://go.zoomyo.com/' + comp + '/tcb-amazon-sync/amazon-confirmshipment/' + amzOrderId + '/' + tId + '/' + tId2 + '/' + tId3 + '/' + tId4 + '/' + tId5 + '/' + id + '/' + carrier;
        console.log(url);
        if (!tId || tId == '') {
            alert('Tracking ID is required!!!');
            return false;
        }
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                $('#shipMessage').show();
                $('#shipMessage').html(response);
                console.log(response);
            },
            error: function(response) {
                console.log(response);
            },
        });
    }
});
(function() {
    var count = 0;
    $("#addTrackingIds").click(function() {
        console.log(this);
        count += 1;

        if (count == 1) {
            $('.trackingId2').show();
        }

        if (count == 2) {
            $('.trackingId3').show();
        }

        if (count == 3) {
            $('.trackingId4').show();
        }

        if (count == 4) {
            $('.trackingId5').show();
            $(this).addClass('disabled');
        }
    });
})();
$("#searchProductTypes").on("click", function() {
    var keywords = $("input[name = 'keywords']").val();
    var comp = $("input[name = 'company_id']").val();
    var country = $("input[name = 'country']").val();
    if (!keywords) {
        alert('Keywords Required!!!');
        return false;
    }
    var url = window.location.origin + '/' + comp + '/tcb-amazon-sync/amazon-producttype/search/' + country + '/' + keywords;
    console.log((keywords));
    if (!price || price == '') {
        alert('Price is required!!!');
        return false;
    }
    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            $('#productTypes').html(response);
            console.log(response);
        },
        error: function(response) {
            console.log(response);
        },
    });
});

$(document).ready(function() {
    $(".modal-header button, .modal-footer button").on("click", function() {
        $(this).parents(".modal").removeClass('show');
        $("body").removeClass('modal-open');
        $(this).parents(".modal").hide('slow');
    });
});

function escapeHtml(str) {
    return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
}