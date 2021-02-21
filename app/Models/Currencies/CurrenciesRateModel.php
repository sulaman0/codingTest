<?php

namespace App\Models\Currencies;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrenciesRateModel extends Model
{

    use HasFactory;

    protected $table = 'currency_rate';
    const AvailableCurrencies = [
        'usd',
        'pkr',
    ];

    public static function getTodayRate()
    {
        ## get today's current rate, but, I am commenting that, due, to might be you check from some other day.
        //        return CurrenciesRateModel::whereDate('created_at', Carbon::now()->format('Y-m-d'))->first();
        return CurrenciesRateModel::orderBy('id', 'desc')->first();
    }


    /**
     * @param int    $amount
     * @param string $currency
     *
     * @purpose Get converted amount in currency
     * @return float|int
     */
    public static function getConvertedAmount(int $amount, string $currency)
    {
        $getTodayRate    = self::getTodayRate();
        $convertedAmount = 0;
        switch ($currency) {
            case 'usd' :
                $convertedAmount = doubleval($amount * $getTodayRate->dollar_rate);
                break;
            case 'pkr':
                $convertedAmount = doubleval($amount * $getTodayRate->pkr_rate);
                break;
            default:
                break;
        }

        return $convertedAmount;
    }

    public static function calculateSenderAndReceiverAmount($senderCurrency, $ReceiverCurrency, $Amount): float
    {
        $getTodayRate = self::getTodayRate();
        if ($senderCurrency == $ReceiverCurrency) {
            return $Amount;
        } elseif ($senderCurrency == 'usd' && $ReceiverCurrency == 'pkr') {
            return doubleval($Amount * $getTodayRate->dollar_rate);
        } elseif ($senderCurrency == 'pkr' && $ReceiverCurrency == 'usd') {
            return doubleval($Amount / $getTodayRate->dollar_rate);
        }
    }
}
