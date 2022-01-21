@stack('ean_input_start')
{{ Form::textGroup('ean', trans('tcb-amazon-sync::general.ean'), 'fa fa-key', ['required' => 'required']) }}
@stack('ean_input_ean')