<?php
namespace App\Http\Requests\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;


class UserResetPasswordRequest extends FormRequest
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
            //'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
            'forgot_password_token' => 'required',
        ];
    }

    public function messages()
    {
        return [
            //'old_password.required' => 'Old password is required',
            'password.required' => 'Password is required',
            'forgot_password_token.required' => 'Token is required',
        ];
    }

    /**
     * [failedValidation [Overriding the event validator for custom error response]]
     * @param  Validator $validator [description]
     * @return [object][object of various validation errors]
     */
    public function failedValidation(Validator $validator)
    {
        $data_error = [];
        $error = $validator->errors()->all(); #if validation fail print error messages
        foreach ($error as $key => $errors):
            $data_error['status'] = 400;
            $data_error['message'] = $errors;
        endforeach;
        return parent::render($data_error, 400);
        //write your bussiness logic here otherwise it will give same old JSON response
        // throw new HttpResponseException(response()->json($data_error, 400));

    }
}
