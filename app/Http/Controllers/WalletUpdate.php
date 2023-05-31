<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletUpdateRequest;
use App\Models\Wallet;
use App\Services\WalletService;

class WalletUpdate extends Controller
{
    public function __construct(protected WalletService $walletService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(WalletUpdateRequest $request, $id)
    {
        $wallet = Wallet::findOrFail($id);
        $data = $request->validated();
        return $this->walletService->makeTransaction(
            $wallet->id,
            $data['type'],
            $data['amount'],
            $data['currency'],
            $data['reason']
        );
    }
}
