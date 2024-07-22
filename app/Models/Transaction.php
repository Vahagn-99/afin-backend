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
 * @property int $login
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
    ];

    public $timestamps = false;

    protected $casts = [
        'balance_start' => 'float',
        'balance_end' => 'float',
        'commission' => 'float',
        'volume_lots' => 'float',
        'equity' => 'float',
    ];

    public string $filter = TransactionFilter::class;

    public function contact(): BelongsTo
    {
        return $this->belongsTo(
            Contact::class,
            'login',
            'login'
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
