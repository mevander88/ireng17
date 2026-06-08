<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameApiController extends Controller
{
    public function all()
    {
        // Ambil semua game dari tabel "games"
        $games = DB::table('games')->get();

        return response()->json($games);
    }
}
