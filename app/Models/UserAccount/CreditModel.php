<?php

namespace App\Models\UserAccount;

use App\Http\Requests\TransferMoney\TransferMoney;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CreditModel extends Model
{

    use HasFactory;

    protected $table = 'user_account_credit';

    /**
     * @param TransferMoney $transferMoney
     * @param int           $DebitId
     * @param string        $receiverCurrency
     * @param double        $ConvertedAmount
     *
     * @return bool
     * @purpose Create Debit
     */
    public static function createCredit(
        TransferMoney $transferMoney,
        int $DebitId,
        string $receiverCurrency,
        float $ConvertedAmount
    ): bool {
        ## to catch in db transaction need to comment this try catch.
        //        try {
        $CreditMode                  = new CreditModel();
        $CreditMode->user_id         = $transferMoney->transfer_to;
        $CreditMode->debit_id        = $DebitId;
        $CreditMode->currency        = $receiverCurrency;
        $CreditMode->transfer_amount = $ConvertedAmount;
        $CreditMode->save();

        return true;
        //        } catch (\Exception $exception) {
        //            Log::error('CreateCreditError', ['error' => $exception->getMessage()]);
        //
        //            return false;
        //    }
    }
}
