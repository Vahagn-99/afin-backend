<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\FilterManager\Filter\HasFilter;
use App\Filters\ManagerRatingFilter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $manager_id
 * @property string $type
 * @property string $total
 * @property string $date
 */
class ManagerRating extends Model
{

    use HasFactory;
    use HasFilter;

    protected $table = 'manager_ratings';
    public string $filter = ManagerRatingFilter::class;

    protected $fillable = [
        'type',
        'total',
        'manager_id',
        'date'
    ];

    public $timestamps = false;

    public function manager(): BelongsTo
    {
        return $this->belongsTo(
            Manager::class,
            'manager_id',
            'id'
        );
    }
}
