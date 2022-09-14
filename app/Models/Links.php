<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    use HasFactory;

    protected $table = 'links';

    protected $fillable = [
        'id',
        'user_id',
        'link',
        'active'
    ];
}
