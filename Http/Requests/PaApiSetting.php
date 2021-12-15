<?php

namespace Modules\TcbAmazonSync\Http\Requests;

use App\Abstracts\Http\FormRequest as Request;

class PaApiSetting extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'api_key' => 'required|string',
            'api_secret_key' => 'required|string',
        ];
    }
}
