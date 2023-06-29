<?php

namespace Core\Loans\Infrastructure\Interfaces\Http\Dto;

use Illuminate\Foundation\Http\FormRequest;

class AddAddressRequest extends FormRequest
{
    public function rules()
    {
        return [
            'address' => 'required|string',
            'postalCode' => 'required',
        ];
    }
}
