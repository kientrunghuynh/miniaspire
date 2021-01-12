<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLoanFormRequest extends APIRequest
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
            'customer_id'   => 'required|numeric|exists:customers,id', // make sure customer exists in the db
            'loan_term'     => 'required|integer|max:12',
            'amount'        => 'required|numeric|min:1000',
        ];
    }

    /**
     * Get the validation messages that apply to the request
     *
     * @return array
     */
    public function messages()
    {
        return [
            'customer_id.required' => 'You must select the Customer applying for this loan',
            'customer_id.exists' => 'The selected Customer does\'t exist',
            'customer_id.required' => 'Please choose the period of the loan',
            'amount.required' => 'Please specify the amount being applied for',
            'loan_term.required' => 'Please specify the loan term for the loan'
        ];
    }
}
