<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBank extends Model
{
    use HasFactory;
    protected $table = 'banks';

    public function Transaksi()
    {
        return $this->hasMany(Transaksi::class, 'bank_id', 'id');
    }
}
