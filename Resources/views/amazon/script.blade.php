<style>
.tcb-card-header {
    border-bottom: 1px solid rgb(221, 221, 221);
    border-top: 1px solid rgb(221, 221, 221);
    margin-bottom: 10px;
    padding: 10px 0px;
    background: rgb(238, 238, 238);
    text-align: center;
}
.tab-content {
    margin-top: 10px;
}
.tcb-inline-block {
    margin: 0 10px;
}
</style>
<script type="text/javscript" id="TcbAmazonSyncScript">
    $('#amazonTab a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
        console.log($(this));
    })
</script>