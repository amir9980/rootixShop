<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'address' => 'required|string',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'paymentMethod' => 'required|string|max:255|in:zarinpal,saderat,cash,asanpardakht',
            'discount_token' => 'nullable|string|max:20'
        ];
    }
}
