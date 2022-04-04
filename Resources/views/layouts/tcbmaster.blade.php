@extends('layouts.admin')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@push('scripts_start')
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/forms/saveForm.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/plugins/piexif.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/plugins/sortable.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/jquery-ui.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/fileinput.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/locales/LANG.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/app.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/forms/fields.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/item.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/tcb/datatables.net/js/jquery.dataTables.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/tcb/datatables.net-bs4/js/dataTables.bootstrap4.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/tcb/datatables.net-buttons/js/dataTables.buttons.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/tcb/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/tcb/datatables.net-buttons/js/buttons.html5.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/tcb/datatables.net-buttons/js/buttons.flash.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/tcb/datatables.net-buttons/js/buttons.print.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/datatables.js?v=' . module_version('tcb-amazon-sync')) }}"></script>

<!-- stylesheets -->
<link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/tcb/datatables.net-bs4/css/dataTables.bootstrap4.min.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
<link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/tcb/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
<link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/tcb/datatables.net-select-bs4/css/select.bootstrap4.min.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
<link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/argon/css/argon.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
<link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/tcb.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
<link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/fileinput.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
<link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/uiset.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
<link rel="stylesheet" href="{{ asset('public/css/custom.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
@endpush