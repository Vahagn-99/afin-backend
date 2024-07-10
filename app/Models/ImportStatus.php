<?php

namespace App\Models;

use App\Enums\ImportStatusType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property ImportStatus $status
 */
class ImportStatus extends Model
{
    use HasFactory;

    protected $table = 'import_status';
    protected $fillable = [
        'id',
        'status',
    ];

    public $incrementing = false;

    public $timestamps = false;
    protected $casts = [
        'status' => ImportStatusType::class
    ];

    public static function importStarted(string $id): void
    {
        static::query()->updateOrCreate([
            'id' => $id,
            'status' => ImportStatusType::STATUS_PENDING,
        ]);
    }

    public static function importCompleted(string $id): void
    {
        static::query()->find($id)->update([
            'status' => ImportStatusType::STATUS_COMPLETED
        ]);
    }

    public static function importFailed(string $id): void
    {
        static::query()->find($id)->update([
            'status' => ImportStatusType::STATUS_FAILED
        ]);
    }
}
