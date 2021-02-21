<?php

namespace App\Models\UserModel;

use App\Events\TransferAmountEvent;
use App\Http\Requests\TransferMoney\TransferMoney;
use App\Models\Currencies\CurrenciesRateModel;
use App\Models\UserAccount\CreditModel;
use App\Models\UserAccount\DebitModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{

    use HasFactory;

    const myUserId = 1;
    protected $table = 'users';

    /**
     * @purpose Get all users
     *
     * @param bool $exceptMe
     *
     * @return UserModel[]|Collection
     */
    public static function getUsers($exceptMe = true)
    {
        return UserModel::all();
    }

    /**
     * @param float $decreaseAmount
     * @param int   $userId
     *
     * @return mixed
     * @purpose Decrease current balance
     */
    public static function decreaseCurrentBalance(float $decreaseAmount, int $userId): bool
    {
        $User = UserModel::where('id', $userId);
        if ($User->first() instanceof UserModel) {
            return (bool)$User->where('current_balance', '>', $decreaseAmount)->lockForUpdate()->decrement(
                'current_balance',
                $decreaseAmount
            );
        } else {
            return false;
        }

    }

    /**
     * @param float $increaseAmount
     * @param int   $increaseUserId
     *
     * @purpose Increase Current Balance of user
     * @return bool
     */
    public static function increaseCurrentBalance(float $increaseAmount, int $increaseUserId): bool
    {
        $User     = UserModel::where('id', $increaseUserId);
        $UserInfo = $User->first();
        if ($UserInfo instanceof UserModel) {
            return $User->lockForUpdate()->increment('current_balance', $increaseAmount);
        } else {
            return false;
        }
    }

    public static function checkIsBalanceAvailable(int $amount, string $currency): bool
    {

    }


    public static function getUser(int $userId)
    {
        return UserModel::findOrFail($userId);
    }

    /**
     * @purpose Transfer Money
     *
     * @param TransferMoney $transferMoney
     */
    public static function transferAmount(TransferMoney $transferMoney)
    {
        DB::transaction(
            function () use ($transferMoney) {
                ## generate debit
                UserModel::decreaseCurrentBalance(
                    doubleval($transferMoney->amount),
                    (int)$transferMoney->transfer_from
                );

                ## Credit Debit of User -- but, I am not creating due to time shortage
                $DebitModelID = DebitModel::createDebit($transferMoney);

                ## Currency conversation on base receiver currency

                $SenderCurrency   = self::getUser($transferMoney->transfer_from)->currency;
                $ReceiverCurrency = self::getUser($transferMoney->transfer_to)->currency;

                $ConvertedAmount = CurrenciesRateModel::calculateSenderAndReceiverAmount(
                    $SenderCurrency,
                    $ReceiverCurrency,
                    $transferMoney->amount
                );

                ## Increase receiver current balance
                UserModel::increaseCurrentBalance(
                    doubleval($ConvertedAmount),
                    (int)$transferMoney->transfer_to
                );

                ## Create Credit.
                CreditModel::createCredit($transferMoney, $DebitModelID, $ReceiverCurrency, $ConvertedAmount);

            },
            5
        );

        TransferAmountEvent::dispatch($transferMoney);
    }
}
