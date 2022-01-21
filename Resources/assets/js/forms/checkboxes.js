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