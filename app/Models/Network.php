<?php

namespace App\Models;

use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Network extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function Transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
