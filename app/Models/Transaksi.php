<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $guarded = ['id'];
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function Bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function Bonus()
    {
        return $this->belongsTo(Bonus::class, 'bonus_id');
    }

    public function scopeActivePendingDepositForUser(Builder $query, int $userId, int $delayHours = 24): Builder
    {
        return $query->where('user_id', $userId)
            ->where('type', 1)
            ->where('status', 1)
            ->where('created_at', '>=', now()->subHours($delayHours));
    }

    #region dashboard

    function get_summary_transaksi()
    {
        $date_yest = date("Y-m-d", strtotime(date('Y-m-d') . " -1 day"));

        $src_today = " BETWEEN '" . date('Y-m-d 00:00:00') . "' AND '" . date('Y-m-d 23:59:59') . "'";
        $src_yesterday = " BETWEEN '" . date($date_yest . ' 00:00:00') . "' AND '" . date($date_yest . ' 23:59:59') . "'";
        $src_month = " BETWEEN '" . date('Y-m-01 00:00:00') . "' AND '" . date('Y-m-d 23:59:59') . "'";
        $src_all = " BETWEEN '" . date('2000 00:00:00') . "' AND '" . date('Y-m-d 23:59:59') . "'";

        $sql = "SELECT
            IFNULL((
                SELECT
                    SUM(trans.nominal)
                FROM
                    transaksi trans
                WHERE
                    trans.approved_at {$src_today}
                    AND trans.status = 2
            ),0) as trans_now,
            IFNULL((
                SELECT
                    COUNT(trans.id)
                FROM
                    transaksi trans
                WHERE
                    trans.approved_at {$src_today}
                    AND trans.status = 2
            ),0) as trans_count,
            IFNULL((
                SELECT
                    SUM(trans.nominal)
                FROM
                    transaksi trans
                WHERE
                    trans.approved_at {$src_yesterday}
                    AND trans.status = 2
            ),0) as trans_yesterday,
            IFNULL((
                SELECT
                    SUM(trans.nominal)
                FROM
                    transaksi trans
                WHERE
                    trans.approved_at {$src_month}
                    AND trans.status = 2
            ),0) as trans_month,
            IFNULL((
                SELECT
                    SUM(trans.nominal)
                FROM
                    transaksi trans
                WHERE
                    trans.approved_at {$src_all}
                    AND trans.status = 2
            ),0) as trans_all
            ";

        $query = DB::select($sql)[0];

        return $query;
    }
    #endregion
}
