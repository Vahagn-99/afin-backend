<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\Translator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\FilterManager\Filter\HasFilter;
use App\Filters\HistoryFilter;

/**
 * @property int $id
 * @property string $from
 * @property string $to
 * @property string $closet_at
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
        'closet_at',
        'created_at'
    ];

    public $timestamps = false;

    public function name(): Attribute
    {
        $closedAt = Carbon::create($this->closet_at);
        $monthName = $closedAt->setLocalTranslator(Translator::get('ru'))->monthName;

        return new Attribute(
            get: fn() => "Отчет за " . ucfirst($monthName) . ' ' . $closedAt->year
        );
    }
}
