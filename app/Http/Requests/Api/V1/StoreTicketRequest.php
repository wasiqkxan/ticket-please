<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
        $rules  = [
            'data.attributes.title' => ['required', 'string', 'max:255'],
            'data.attributes.description' => ['required', 'string'],
            'data.attributes.status' => ['required', 'string', 'in:A,S,C,X,R'],
        ];

        if($this->routeIs('tickets.store')){
            $rules['data.relationships.author.data.id'] = ['required', 'integer'];

        }
        return $rules;
    }
    public function messages(){
        return [
            'data.attributes.title.required' => 'Title is required',
            'data.attributes.title.string' => 'Title must be a string',
            'data.attributes.title.max' => 'Title must not exceed 255 characters',
            'data.attributes.description.required' => 'Description is required',
            'data.attributes.description.string' => 'Description must be a string',
            'data.attributes.status.required' => 'Status is required',
            'data.attributes.status.string' => 'Status must be a string',
            'data.attributes.status.in' => 'Status must be one of A, S, C, X, R',
            'data.relationships.author.data.id.required' => 'Author ID is required',
            'data.relationships.author.data.id.integer' => 'Author ID must be an integer',
        ];
    }
}
