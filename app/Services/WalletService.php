<?php

namespace App\Services;

use App\Exceptions\FailedTransaction;
use App\Exceptions\InsufficientBalance;
use App\Models\CurrencyRate;
use App\Models\Transaction;
use App\Models\Wallet;
use Exception;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function convertAmountToCurrency($amount, $from, $to)
    {
        if ($from === $to) {
            return $amount;
        }
        $currencyRate = CurrencyRate::where(['from' => $from, 'to' => $to])
            ->orderByDesc('created_at')
            ->first();
        return $currencyRate->rate * $amount;
    }

    public function makeTransaction($wallet_id, $type, $amount, $currency, $reason)
    {
        return DB::transaction(function () use ($wallet_id, $type, $amount, $currency, $reason) {
            $wallet = Wallet::lockForUpdate()->find($wallet_id);
            $convertedAmount = $this->convertAmountToCurrency($amount, $currency, $wallet->currency);

            if ($type === Transaction::TYPE_DEBIT && $wallet->balance < $convertedAmount) {
                throw new InsufficientBalance;
            }

            if ($type === Transaction::TYPE_DEBIT) {
                $wallet->update(['balance' => $wallet->balance - $convertedAmount]);
            } else {
                $wallet->update(['balance' => $wallet->balance + $convertedAmount]);
            }

            return Transaction::create([
                'wallet_id' => $wallet_id,
                'type' => $type,
                'amount' => $convertedAmount,
                'currency' => $wallet->currency,
                'reason' => $reason
            ]);
        });
    }
}

