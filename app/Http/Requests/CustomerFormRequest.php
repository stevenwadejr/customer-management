<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\MessageBag;

class CustomerFormRequest extends Request {

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
            'first_name' => 'required',
            'last_name' => 'required'
        ];
    }

    public function response(array $errors)
    {
        flash()->error(
            implode('<br>', (new MessageBag($errors))->all())
        );

        return parent::response($errors);
    }

}
