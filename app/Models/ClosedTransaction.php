<?php

namespace App\Models;

use App\Modules\FilterManager\Filter\HasFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Filters\ClosedTransactionFilter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $login
 * @property int $history_id
 * @property float $lk
 * @property string $currency
 * @property float $deposit
 * @property float $withdrawal
 * @property float $volume_lots
 * @property float $equity
 * @property float $balance_start
 * @property float $balance_end
 * @property float $commission
 * @property float $contact_id
 * @property string $created_at
 *
 * /----------scopes---------/
 * @method static Builder whereDoesntSynced()
 */
class ClosedTransaction extends Model
{

    use HasFactory;
    use HasFilter;

    public string $filter = ClosedTransactionFilter::class;

    protected $table = 'closed_transactions';

    protected $fillable = [
        'login',
        'lk',
        'currency',
        'deposit',
        'withdrawal',
        'volume_lots',
        'equity',
        'balance_start',
        'balance_end',
        'commission',
        'created_at',
        'contact_id',
        'history_id',
    ];

    public $timestamps = false;

    public $incrementing = false;

    public function contact(): BelongsTo
    {
        return $this->belongsTo(
            Contact::class,
            'login',
            'login'
        );
    }

    public function history(): BelongsTo
    {
        return $this->belongsTo(
            History::class,
            'history_id',
            'id'
        );
    }

    public function scopeWhereDoesntSynced(Builder $query): Builder
    {
        return $query->whereDoesntHave('contact');
    }
}
