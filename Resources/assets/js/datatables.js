$(document).ready(function() {
    if ($('#amzCategories').length) {
        var url = $('#amzCategories').data('route');
        console.log(url);
        $('#amzCategories').DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            pagingType: 'full_numbers',
            iDisplayLength: 25,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'node_path', name: 'node_path' },
                { data: 'root_node', name: 'root_node' },
                { data: 'uk_node_id', name: 'uk_node_id' },
                { data: 'fr_node_id', name: 'fr_node_id' },
                { data: 'it_node_id', name: 'it_node_id' },
                { data: 'es_node_id', name: 'es_node_id' },
                { data: 'de_node_id', name: 'de_node_id' },
            ],
            language: {
                oPaginate: {
                    sFirst: '<i class="fa fa-step-backward text-primary"></i>',
                    sPrevious: '<i class="fa fa-backward text-info"></i>',
                    sNext: '<i class="fa fa-forward text-info"></i>',
                    sLast: '<i class="fa fa-step-forward text-primary"></i>'
                }
            }
        });
    }

    if ($('#amzCategoriesSmall').length) {
        var url = $('#amzCategoriesSmall').data('route');
        console.log(url);
        $('#amzCategoriesSmall').DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            pagingType: 'full_numbers',
            iDisplayLength: 25,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'node_path', name: 'node_path' },
                { data: 'root_node', name: 'root_node' },
                { data: 'uk_node_id', name: 'uk_node_id' },
                { data: 'fr_node_id', name: 'fr_node_id' },
                { data: 'it_node_id', name: 'it_node_id' },
                { data: 'es_node_id', name: 'es_node_id' },
                { data: 'de_node_id', name: 'de_node_id' },
            ],
            language: {
                oPaginate: {
                    sFirst: '<i class="fa fa-step-backward text-primary"></i>',
                    sPrevious: '<i class="fa fa-backward text-info"></i>',
                    sNext: '<i class="fa fa-forward text-info"></i>',
                    sLast: '<i class="fa fa-step-forward text-primary"></i>'
                }
            }
        });
    }

    $(".closeModal").on("click", function() {
        var div = $(this).data("dismiss");
        console.log($(div));
        $('body').removeClass("modal-open");
        $('body').css("padding", "");
        $(div).hide("slow");
        $(".modal-backdrop").hide("slow");
        $(div).removeClass("show");
    });

    if ($('#itemsDataTable').length) {
        var url = $('#itemsDataTable').data('route');
        console.log(url);
        $('#itemsDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            pagingType: 'full_numbers',
            iDisplayLength: 25,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'title', name: 'title' },
                { data: 'sku', name: 'sku' },
                { data: 'asin', name: 'asin' },
                { data: 'warnings', name: 'warnings' },
                { data: 'category', name: 'category' },
                { data: 'quantity', name: 'quantity' },
                { data: 'price', name: 'price' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            language: {
                oPaginate: {
                    sFirst: '<i class="fa fa-step-backward text-primary"></i>',
                    sPrevious: '<i class="fa fa-backward text-info"></i>',
                    sNext: '<i class="fa fa-forward text-info"></i>',
                    sLast: '<i class="fa fa-step-forward text-primary"></i>'
                }
            }
        });
    }

    if ($('#ptDataTable').length) {
        var url = $('#ptDataTable').data('route');
        console.log(url);
        $('#ptDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            pagingType: 'full_numbers',
            iDisplayLength: 25,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'uk', name: 'uk' },
                { data: 'de', name: 'de' },
                { data: 'fr', name: 'fr' },
                { data: 'it', name: 'it' },
                { data: 'es', name: 'es' },
                { data: 'se', name: 'se' },
                { data: 'nl', name: 'nl' },
                { data: 'pl', name: 'pl' },
                { data: 'us', name: 'us' },
                { data: 'ca', name: 'ca' },
            ],
            language: {
                oPaginate: {
                    sFirst: '<i class="fa fa-step-backward text-primary"></i>',
                    sPrevious: '<i class="fa fa-backward text-info"></i>',
                    sNext: '<i class="fa fa-forward text-info"></i>',
                    sLast: '<i class="fa fa-step-forward text-primary"></i>'
                }
            }
        });
    }

    if ($('#ptDataTableSmall').length) {
        var url = $('#ptDataTableSmall').data('route');
        console.log(url);
        $('#ptDataTableSmall').DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            pagingType: 'full_numbers',
            iDisplayLength: 10,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'uk', name: 'uk' },
                { data: 'de', name: 'de' },
                { data: 'fr', name: 'fr' },
                { data: 'it', name: 'it' },
                { data: 'es', name: 'es' },
                { data: 'se', name: 'se' },
                { data: 'nl', name: 'nl' },
                { data: 'pl', name: 'pl' },
                { data: 'us', name: 'us' },
                { data: 'ca', name: 'ca' },
            ],
            language: {
                oPaginate: {
                    sFirst: '<i class="fa fa-step-backward text-primary"></i>',
                    sPrevious: '<i class="fa fa-backward text-info"></i>',
                    sNext: '<i class="fa fa-forward text-info"></i>',
                    sLast: '<i class="fa fa-step-forward text-primary"></i>'
                }
            }
        });
    }
});