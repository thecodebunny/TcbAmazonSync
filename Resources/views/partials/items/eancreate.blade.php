@stack('ean_input_start')
{{ Form::textGroup('ean', trans('inventory::general.ean'), 'fa fa-key', ['required' => 'required']) }}
@stack('ean_input_ean')