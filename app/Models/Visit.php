<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'client_id',
    'site_key',
    'page_url',
    'page_host',
    'referrer',
    'ip',
    'country',
    'city',
    'device_type',
    'browser',
    'platform',
    'user_agent',
    'language',
    'screen_width',
    'screen_height',
    'timezone',
    'visited_at',
])]
class Visit extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'visited_at' => 'datetime',
        ];
    }
}
