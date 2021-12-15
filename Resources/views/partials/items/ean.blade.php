@stack('ean_input_start')
{{ Form::textGroup('ean', trans('inventory::general.ean'), 'fa fa-key', ['required' => 'required'], !empty($amz_item->ean) ? $amz_item->ean : '') }}
@stack('ean_input_ean')