<?php

namespace Amanat\RpsCounter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $url
 * @property string $ip
 * @property string $type
 * @property float $speed
 * @property int $status_code
 *
 * @method static RpsCount create(array $params)
 */
class RpsCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'ip',
        'type',
        'speed',
        'status_code',
    ];
}