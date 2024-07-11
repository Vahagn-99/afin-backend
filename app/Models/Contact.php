<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $login
 * @property string $client
 * @property string $manager
 * @property string $group
 * @property string $analytic
 * @property string $branch
 */
class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'login',
        'client',
        'manager',
        'group',
        'branch',
        'analytic',
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

    public function closedTransactions(): HasMany
    {
        return $this->hasMany(
            ClosedTransaction::class,
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
