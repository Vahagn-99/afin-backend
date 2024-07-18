<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\FilterManager\Filter\HasFilter;
use App\Filters\ManagerBonusFilter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $contact_id
 * @property int $manager_id
 * @property float $deposit
 * @property float $volume_lots
 * @property float $bonus
 * @property float $potential_bonus
 * @property float $payoff
 * @property float $paid
 * @property string $date
 *
 * @property-read Manager $manager
 * @property-read Contact $contact
 */
class ManagerBonus extends Model
{

    use HasFactory;
    use HasFilter;

    protected $table = 'manager_bonuses';

    public $timestamps = false;

    protected $fillable = [
        'contact_id',
        'manager_id',
        'deposit',
        'volume_lots',
        'bonus',
        'potential_bonus',
        'payoff',
        'paid',
        'date'
    ];

    public string $filter = ManagerBonusFilter::class;

    public function manager(): BelongsTo
    {
        return $this->belongsTo(
            Manager::class,
            'manager_id',
            'id'
        );
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(
            Contact::class,
            'contact_id',
            'id'
        );
    }
}
