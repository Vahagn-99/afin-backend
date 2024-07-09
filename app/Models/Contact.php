<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $client
 * @property string $manager
 * @property string $group
 * @property string $branch
 */
class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'client',
        'manager',
        'group',
        'branch',
    ];
}
