@stack('ean_input_start')
{{ Form::textGroup('ean', trans('tcb-amazon-sync::general.ean'), 'fa fa-key', ['required' => 'required'], !empty($amzItem->ean) ? $amzItem->ean : '') }}
@stack('ean_input_ean')