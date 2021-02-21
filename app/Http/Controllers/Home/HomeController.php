<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferMoney\TransferMoney;
use App\Models\Currencies\CurrenciesRateModel;
use App\Models\User;
use App\Models\UserModel\UserModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        return view(
            'transfer.transfer',
            [
                'available_currencies' => CurrenciesRateModel::AvailableCurrencies,
                'users'                => UserModel::getUsers(),
            ]
        );
    }

    public function transferAmount(TransferMoney $transferMoney): \Illuminate\Http\JsonResponse
    {
        ## denined self transaction
        if ($transferMoney->transfer_from == $transferMoney->transfer_to) {
            return response()->json(
                [
                    'message' => trans('demo.invalid_transaction'),
                    'errors'  => [
                        'invalid_amount' => ['demo.self_transaction'],
                    ],
                ],
                422
            );
        }

        ## transfer amount
        UserModel::transferAmount($transferMoney);

        return response()->json(
            [
                'message'=> trans('demo.transaction_done_successfully'),
                'success' => true,
            ]
        );
    }

}
