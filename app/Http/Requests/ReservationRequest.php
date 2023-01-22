<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'start'=>'required|date|date_format:Y-m-d',
            'stop'=>'nullable|date|date_format:Y-m-d',
            'days'=>'nullable|integer|min:1',
            'beds'=>'required|integer|min:1'
        ];
    }
}
