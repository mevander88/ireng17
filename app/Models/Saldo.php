<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Saldo_log;
use Illuminate\Support\Facades\DB;

class Saldo extends Model
{
    use HasFactory;
    protected $table = 'saldo';
    private $limit = 9999999999;
    protected $guarded = ['id'];
    /**
     * Save saldo with log
     * @param string $type - Trans | Game
     */


    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
