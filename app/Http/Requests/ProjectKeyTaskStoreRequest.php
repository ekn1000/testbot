<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProjectKeyTaskStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $stopOnFirstFailure = true;

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
            'pid'=>'required',
            'device' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'pid.required' => 'Err pid',
            'device.required' => 'Err device',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'device'  =>  request()->get('device') ?? 'all'
        ]);
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'err'      => $validator->messages()->first(),
            'status' => 'stopped'
        ]));
    }
}
