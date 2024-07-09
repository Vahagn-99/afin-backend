<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\FilterManager\Filter\HasFilter;
use App\Filters\PositionFilter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $login
 * @property string $utm
 * @property string $opened_at
 * @property string $updated_at
 * @property ?string $closed_at
 * @property float $action
 * @property float $symbol
 * @property float $lead_volume
 * @property float $price
 * @property ?float $profit
 * @property float $reason
 * @property float $float_result
 * @property string $currency
 * @property float $position
 * @property ?int $contact_id
 *
 * @method static Builder whereOpened()
 * @method static Builder whereClosed()
 */
class Position extends Model
{
    use HasFactory;
    use HasFilter;

    public string $filter = PositionFilter::class;
    protected $fillable = [
        'login',
        'utm',
        'opened_at',
        'updated_at',
        'closed_at',
        'action',
        'symbol',
        'lead_volume',
        'price',
        'profit',
        'reason',
        'float_result',
        'currency',
        'position',
        'contact_id',
    ];

    public $timestamps = false;
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function scopeWhereClosed(Builder $builder): Builder
    {
        return $builder->whereNull('closed_at');
    }

    public function scopeWhereOpened(Builder $builder): Builder
    {
        return $builder->whereNotNull('closed_at');
    }
}
