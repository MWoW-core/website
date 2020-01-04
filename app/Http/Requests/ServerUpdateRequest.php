<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ServerStatus;

class ServerUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['string', Rule::in(ServerStatus::getValues())],

            'realmlist' => 'string',

            'ssh_key' => 'string|max:65535',
            'ssh_address' => 'nullable|ip',
            'ssh_port' => 'nullable|numeric'
        ];
    }
}
