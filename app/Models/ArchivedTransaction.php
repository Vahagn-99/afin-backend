<?php

namespace App\Models;

use App\Filters\ArchivedTransactionFilter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $archive_id
 */
class ArchivedTransaction extends Transaction
{
    public string $filter = ArchivedTransactionFilter::class;

    protected $table = 'archived_transactions';

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
        'contact_id',
        'archive_id',
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
