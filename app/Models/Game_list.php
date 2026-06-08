<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Support\Facades\DB;

class Game_list extends Model
{
    protected $table = 'game_list';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'provider',
        'image',
        'image_is_url',
        'game_id',
        'game_id_long',
        'game_name',
        'game_type_id',
        'game_demo',
        'category',
        'technology',
        'technology_id',
        'platform',
        'aspect_ratio',
        'jurisdictions',
        'frb_available',
        'data_type',
        'features',
        'status',
        'created_at',
        'updated_at'
    ];    


    function get_game_list( $provider, $type){
        return $this->select('game_list.*', DB::RAW('IFNULL(game_locks.status, game_list.game_locked) as game_locks'))
            ->where([
                'data_type' => $type,
                'provider' => $provider,
                'game_list.status' => 1
            ])->leftJoin('game_locks', function($join){
                $user_id = empty(Auth()->user()) ? 0 : Auth()->user()->id;
                $join->on('game_list.id', '=', 'game_locks.game_id')
                ->where('game_locks.user_id', '=', $user_id)
                ->where('game_locks.status', '=', 1);
            })->get();
    }
}
