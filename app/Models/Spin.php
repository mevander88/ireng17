<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spin extends Model
{
    use HasFactory;
    protected $table = 'spins';
    protected $guarded = ['id'];
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
