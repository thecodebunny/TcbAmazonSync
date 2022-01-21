@extends('layouts.admin')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@push('scripts_start')
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/argon/app.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/forms/saveForm.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/plugins/piexif.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/plugins/sortable.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/jquery-ui.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/fileinput.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/locales/LANG.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/app.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/forms/fields.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/item.js?v=' . module_version('tcb-amazon-sync')) }}"></script>

<!-- stylesheets -->
<link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/argon/css/argon.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
<link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/tcb.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
<link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/fileinput.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
<link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/uiset.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
<link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/tcb.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
@endpush