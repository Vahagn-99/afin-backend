<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\FilterManager\Filter\HasFilter;
use App\Filters\ManagerFilter;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $branch
 * @property string $avatar
 * @property string $created_at
 */
class Manager extends Model
{

    use HasFactory;
    use HasFilter;

    public string $filter = ManagerFilter::class;

    protected $table = 'managers';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'type',
        'branch',
        'avatar'
    ];

    public function transactions(): HasManyThrough
    {
        return $this->hasManyThrough(
            Transaction::class,
            Contact::class,
            'login',
            'login',
            'id',
            'manager_id'
        );
    }

    public function archivedTransactions(): HasManyThrough
    {
        return $this->hasManyThrough(
            ArchivedTransaction::class,
            Contact::class,
            'login',
            'login',
            'id',
            'manager_id'
        );
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(
            ManagerRating::class,
            'manager_id',
            'id'
        );
    }

    public function sellingCourses()
    {
        return new Attribute(
            get: fn() => $this->ratings()->groupBy('course_id')->value('total'),
        );
    }
}
