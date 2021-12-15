<?php

namespace Modules\TcbAmazonSync\Http\Requests;

use App\Abstracts\Http\FormRequest as Request;

class SpApiSetting extends Request
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
            'app_name' => 'required|string',
            'app_id' => 'required|string',
        ];
    }
}
