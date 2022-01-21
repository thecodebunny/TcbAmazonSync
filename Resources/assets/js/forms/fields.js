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
    $(this).attribute("selected", "selected");
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