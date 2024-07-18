<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property string $id
 * @property string $api_key
 * @property string $name
 * @property string $created_at
 *
 * @method static Builder whereValid(string $clientId, string $clientApiKey)
 * @method static Builder currentValid()
 */
class WebhookClient extends Model
{
    protected $table = 'webhook_clients';

    protected $fillable = [
        'id',
        'api_key',
        'name',
    ];

    public $incrementing = false;
    public $timestamps = false;

    public function scopeWhereValid(Builder $query, string $clientId, string $clientApiKey): Builder
    {
        return $query
            ->where('id', $clientId)
            ->where('api_key', $clientApiKey)
            ->where('created_at', '>=', now()->subMonth());
    }

    public function scopeCurrentValid(Builder $query): Builder
    {
        return $query
            ->where('created_at', '>=', now()->subMonth())
            ->latest()
            ->limit(1);
    }

    public static function recreate(): WebhookClient
    {
        /** @var WebhookClient|null $old */
        $old = static::currentValid()->first();
        if ($old) {
            $new = $old->replicate(['created_at', 'api_key']);
            $old->delete();
        } else {
            $new = new static();
            $new->id = config('services.amocrm.client_id');
            $new->name = config('services.amocrm.client_domain');
        }

        $new->api_key = Str::random(32);
        $new->save();
        return $new;
    }
}
