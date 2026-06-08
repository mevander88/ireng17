<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fiver_Game extends Model
{
    use HasFactory;
    protected $table = 'fiver_games';
    protected $guarded = ['id'];
}
