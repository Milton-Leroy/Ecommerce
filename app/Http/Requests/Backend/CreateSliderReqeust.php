<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CreateSliderReqeust extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'banner' => ['required', 'image', 'max:2048'],
            'type' => ['string', 'max:200'],
            'title' => ['required','string', 'max:200'],
            'starting_price' => ['max:200'],
            'btn_url' => ['url'],
            'serial' => ['required','int'],
            'status' => ['required', 'boolean'],
        ];
    }
}
