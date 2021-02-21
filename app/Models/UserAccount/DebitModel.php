<?php

namespace App\Models\UserAccount;

use App\Http\Requests\TransferMoney\TransferMoney;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DebitModel extends Model
{

    use HasFactory;

    protected $table = 'user_account_debit';

    /**
     * @param TransferMoney $transferMoney
     *
     * @purpose Create Debit
     * @return int
     */
    public static function createDebit(TransferMoney $transferMoney): int
    {
        ## try catch is comment to catch in DB Transaction error
        //        try {
        $DebitModel                  = new DebitModel();
        $DebitModel->user_id         = $transferMoney->transfer_from;
        $DebitModel->credit_id       = null;
        $DebitModel->currency        = $transferMoney->currency;
        $DebitModel->transfer_amount = $transferMoney->amount;
        $DebitModel->save();

        return $DebitModel->id;
        //        } catch (\Exception $exception) {
        //            Log::error('CreateDebitError', ['error' => $exception->getMessage()]);
        //
        //            return false;
        //        }
    }
}
