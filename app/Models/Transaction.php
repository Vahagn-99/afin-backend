<?php

namespace App\Models;

use App\Filters\TransactionFilter;
use App\Modules\FilterManager\Filter\HasFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property int $id
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
class Transaction extends Model
{
    use HasFactory;
    use HasFilter;

    protected $fillable = [
        'id',
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
    ];

    public $timestamps = false;

    public string $filter = TransactionFilter::class;

    public function contact(): BelongsTo
    {
        return $this->belongsTo(
            Contact::class,
            'contact_id',
            'id'
        );
    }

    /**
     * select all not synced with amocrm contact transactions,
     */
    public function scopeWhereDoesntSynced(Builder $query): Builder
    {
        return $query->whereDoesntHave('contact');
    }
}
