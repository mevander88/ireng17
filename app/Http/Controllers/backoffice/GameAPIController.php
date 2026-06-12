<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Api\fiver;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GameAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $SG = new fiver();
        $act = json_decode($SG->gamelist('PRAGMATIC'));
        $games = $act->games ?? [];
        $synced = 0;

        foreach ($games as $game) {
            if (empty($game->game_code) || empty($game->game_name)) {
                continue;
            }

            DB::table('fiver_games')->updateOrInsert(
                [
                    'game_code' => $game->game_code,
                    'game_provider' => 'PRAGMATIC',
                ],
                [
                    'game_name' => $game->game_name,
                    'game_image' => $game->banner ?? '',
                    'game_category' => 'slot',
                    'game_rtp' => null,
                    'status' => (string) ($game->status ?? 1),
                    'updated_at' => now(),
                ]
            );
            $synced++;
        }

        return response()->json(['ok' => true, 'provider' => 'PRAGMATIC', 'synced' => $synced]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
