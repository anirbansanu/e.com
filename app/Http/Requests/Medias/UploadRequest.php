<?php

namespace App\Http\Requests\Medias;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UploadRequest extends FormRequest
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
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // $fileExtension = $this->file->getClientOriginalExtension();
        // $allowedExtensions = ['mp4', ];
        // $maxSize = in_array($fileExtension, $allowedExtensions) ? 500000 : 5000;
        // return [
        //     'file' => [
        //         Rule::requiredIf(!$this->has('file_url')), // Optional: Make the file field required only if file_url is not provided
        //         'file',
        //         'mimes:jpeg,png,jpg,gif,svg,mp4,heif', // Modify the allowed mime types as needed
        //         "max:$maxSize",
        //     ],
        // ];
        return [
            'file' => 'required|file|max:500000',

        ];
    }
}
