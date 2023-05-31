<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    public const TYPE_DEBIT = 'debit';

    public const TYPE_CREDIT = 'credit';

    protected $fillable = [
        'type',
        'amount',
        'currency',
        'reason',
        'wallet_id'
    ];

    protected $visible = [
        'id',
        'type',
        'amount',
        'currency',
        'reason',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
