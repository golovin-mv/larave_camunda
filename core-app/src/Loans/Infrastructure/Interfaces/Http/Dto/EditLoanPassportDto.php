<?php

namespace Core\Loans\Infrastructure\Interfaces\Http\Dto;

use Illuminate\Foundation\Http\FormRequest;

class EditLoanPassportDto extends FormRequest
{
    public function rules(): array
    {
        return [
            'number' => 'required'
        ];
    }
}
