<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\FilterManager\Filter\HasFilter;
use App\Filters\ContactFilter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $login
 * @property string $name
 * @property int $manager_id
 * @property string $analytic
 * @property string $url
 */
class Contact extends Model
{

    use HasFactory;
    use HasFilter;

    public string $filter = ContactFilter::class;

    protected $fillable = [
        'id',
        'login',
        'name',
        'manager_id',
        'analytic',
        'url',
    ];

    protected $table = 'contacts';

    public $timestamps = false;

    public $incrementing = false;

    public function transactions(): HasMany
    {
        return $this->hasMany(
            Transaction::class,
            'login',
            'login'
        );
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(
            Manager::class,
            'manager_id',
            'id'
        );
    }

    public function archivedTransactions(): HasMany
    {
        return $this->hasMany(
            ArchivedTransaction::class,
            'login',
            'login'
        );
    }

    public function closedPositions(): HasMany
    {
        return $this->hasMany(
            Position::class,
            'login',
            'login'
        )->whereNotNull('closed_at');
    }

    public function openedPositions(): HasMany
    {
        return $this->hasMany(
            Position::class,
            'login',
            'login'
        )->whereNull('closed_at');
    }
}
