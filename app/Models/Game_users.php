<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Support\Facades\DB;

/**
 * Class for generating api & prepare curl units
 */
class Game_users extends Model
{
    protected $table = 'game_users';

    // check if data exist
    function check_exist($provider, $user_id){
        $datas = $this->where([
            'provider' => $provider,
            'user_id' => $user_id,
            'status' => 1
        ])->first();

        if(!empty($datas)){
            if(empty($datas->ext_id)){
                $datas->status = 0;
                $datas->save();
                  
                return false;
            }

            return $datas->ext_id;
        }else{
            return true;
        }
    }

    // 
}
