<?php

namespace App\Models;

use App\Modules\JsonManager\Json;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\FilterManager\Filter\HasFilter;
use App\Filters\HistoryFilter;
use Illuminate\Support\Facades\Cache;

/**
 * @property int $id
 * @property string $from
 * @property string $to
 * @property string $path
 * @property string $created_at
 * @property-read string $name
 */
class History extends Model
{
    use HasFactory;
    use HasFilter;

    public string $filter = HistoryFilter::class;

    protected $fillable = [
        'from',
        'to',
        'path',
        'created_at'
    ];

    public $timestamps = false;

    public function name(): Attribute
    {
        $dateFromPath = Cache::rememberForever('cached_history_' . $this->id, fn() => Json::nameFromPath($this->path));

        return new Attribute(
            get: fn() => "Отчет за " . $dateFromPath
        );
    }
}
