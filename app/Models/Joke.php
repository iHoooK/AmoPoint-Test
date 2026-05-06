<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['external_id', 'type', 'setup', 'punchline'])]
class Joke extends Model
{
    use HasFactory;
}
