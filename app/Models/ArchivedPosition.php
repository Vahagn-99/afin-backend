<?php

namespace App\Models;

use App\Filters\ArchivedPositionFilter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $archive_id
 */
class ArchivedPosition extends Position
{
    protected $table = 'archived_positions';

    public string $filter = ArchivedPositionFilter::class;

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
        'archive_id'
    ];

    public function archive(): BelongsTo
    {
        return $this->belongsTo(
            Archive::class,
            'archive_id',
            'id'
        );
    }
}
