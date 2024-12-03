<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTravelOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'solicitante' => 'required',
            'destino' => 'required',
            'data_ida' => 'required|after_or_equal:today',
            'data_volta' => 'required|after:data_ida'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'solicitante.required' => 'O campo solicitante é obrigatório.',
            'destino.required' => 'O campo destino é obrigatório.',
            'data_ida.required' => 'A data de ida é obrigatória.',
            'data_ida.after_or_equal' => 'A data de ida deve ser uma data futura ou igual a hoje.',
            'data_volta.required' => 'A data de volta é obrigatória.',
            'data_volta.after' => 'A data de volta deve ser posterior à data de ida.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'message' => 'Falha ao cadastrar pedido.',
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
