<?php

namespace App\Http\Requests\TransferMoney;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\RequestConstants;
use App\Models\Currencies\CurrenciesRateModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransferMoney extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            //            'full_name'     => 'required|max:40|regex:/^[\.\,\w\s-]*$/u',
            'amount'        => [
                'required',
                'numeric',
                'regex:/^[+]?\d+([.]\d+)?$/u',
                'min:1',
            ],
            'transfer_to'   => 'required|exists:users,id',
            'transfer_from' => 'required|exists:users,id',
            'currency'      => 'required|in:'.implode(',', CurrenciesRateModel::AvailableCurrencies),
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.*'   => trans('demo.invalid_full_name'),
            'amount.*'      => trans('demo.invalid_amount'),
            'transfer_to.*' => trans('demo.invalid_transfer_member'),
            'currency.*'    => trans('demo.invalid_currency'),
        ];
    }
}
