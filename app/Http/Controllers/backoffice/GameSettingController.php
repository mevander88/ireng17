<?php

namespace App\Http\Controllers\backoffice;

use App\Models\User;
use App\Http\Api\fiver;
use App\Models\Setting;
use App\Models\Game_list;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class GameSettingController extends Controller
{
    /**
     * Menampilkan daftar game dan data pemain
     */
    public function index()
    {
        try {
            $SG = new fiver();
            $act = json_decode($SG->callPlayer());

            if (!$act || !isset($act->data)) {
                Log::error('Gagal memuat data pemain dari API fiver', ['response' => $act]);
                return redirect()->back()->with('error', 'Gagal memuat data pemain');
            }

            $data = $act->data;

            // Tambahkan kolom id auto increment
            $dataWithIds = array_map(function ($item, $index) {
                $item->id = $index + 1;
                return $item;
            }, $data, array_keys($data));

            // Letakkan id di urutan awal
            $dataWithIds = array_map(function ($item) {
                return ['id' => $item->id] + (array) $item;
            }, $dataWithIds);

            return view('backoffice.games.game_setting', ['x' => $dataWithIds]);
        } catch (\Throwable $e) {
            Log::error('Error di GameSettingController@index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data.');
        }
    }

    /**
     * Update data setting web
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_web' => 'nullable|string|max:120',
                'telp' => 'nullable|string|max:30',
                'wa' => 'nullable|string|max:30',
                'tele' => 'nullable|string|max:80',
                'running_text' => 'nullable|string|max:255',
                'live_chat' => 'nullable|string',
                'msg_popup' => 'nullable|string',
                'logo' => 'nullable|file|mimes:png,jpg,jpeg,webp,gif|max:4096',
            ]);

            $data = Setting::findOrFail($id);

            $data->fill([
                'nama_web' => $request->nama_web,
                'telp' => $request->telp,
                'wa' => $request->wa,
                'tele' => $request->tele,
                'running_text' => $request->running_text,
                'live_chat' => $request->live_chat,
                'msg_popup' => $request->msg_popup,
                'bg_color' => $request->bg_color,
                'bg_color_2' => $request->bg_color_2,
                'bg_color_single' => $request->bg_color_single ?? 0,
                'nav_color' => $request->nav_color,
                'nav_login' => $request->nav_login,
                'nav_login_2' => $request->nav_login_2,
                'nav_color_trans' => $request->nav_color_trans,
                'nav_color_2' => $request->nav_color_2,
                'txt_color' => $request->txt_color,
                'maintenance_mode' => $request->maintenance_mode ?? 0,
            ]);

            // Upload logo
            if ($request->hasFile('logo')) {
                $file_path = public_path('storage/logo/' . $data->logo);
                if (File::exists($file_path)) {
                    unlink($file_path);
                }

                File::ensureDirectoryExists(public_path('storage/logo'));
                $imgname = time() . '_' . Str::random(12) . '.' . $request->file('logo')->extension();
                $request->file('logo')->move(public_path('storage/logo'), $imgname);
                $data->logo = $imgname;
            }

            $data->save();

            return redirect()->back()->with('success', 'Data berhasil diubah');
        } catch (\Throwable $e) {
            Log::error('Error saat update Setting', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal menyimpan perubahan.');
        }
    }

    /**
     * Lock game tertentu
     */
    public function lock(Request $request)
    {
        try {
            $data = Game_list::findOrFail($request->game_id);
            $data->game_locked = 1;
            $data->save();
            return redirect()->back()->with('success', 'Game berhasil dikunci');
        } catch (\Throwable $e) {
            Log::error('Error lock game: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengunci game');
        }
    }

    /**
     * Unlock game tertentu
     */
    public function unlock(Request $request)
    {
        try {
            $data = Game_list::findOrFail($request->game_id);
            $data->game_locked = 0;
            $data->save();
            return redirect()->back()->with('success', 'Game berhasil dibuka');
        } catch (\Throwable $e) {
            Log::error('Error unlock game: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuka game');
        }
    }

    /**
     * Ambil list call RTP dari API
     */
    public function callList(Request $request)
    {
        try {
            $SG = new fiver();
            $act = json_decode($SG->callList(
                $request->provider,
                $request->game_code,
                $request->username
            ));
            return $act;
        } catch (\Throwable $e) {
            Log::error('Error callList: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'Gagal mengambil data call list']);
        }
    }

    /**
     * Apply RTP melalui API
     */
    public function callApply(Request $request)
    {
        $rtp = $request->input('call_rtp');

        if (!is_numeric($rtp)) {
            return response()->json(['status' => 'error', 'msg' => 'RTP harus berupa angka'], 400);
        }

        try {
            $SG = new fiver();
            $act = $SG->callApply(
                $request->input('provider'),
                $request->input('game_code'),
                $request->input('username'),
                (int) $rtp,
                $request->input('call_type')
            );

            return response()->json(['status' => 'success', 'data' => $act]);
        } catch (\Throwable $e) {
            Log::error('Error callApply: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'Gagal mengubah RTP']);
        }
    }

    public function callHistory(Request $request)
    {
        $validated = $request->validate([
            'offset' => 'nullable|integer|min:0',
            'limit' => 'nullable|integer|min:1|max:500',
        ]);

        try {
            $SG = new fiver();
            $response = json_decode($SG->callHistory(
                (int) ($validated['offset'] ?? 0),
                (int) ($validated['limit'] ?? 100)
            ), true) ?: [];

            return response()->json($response);
        } catch (\Throwable $e) {
            Log::error('Error callHistory: ' . $e->getMessage());
            return response()->json(['status' => 0, 'msg' => 'Gagal mengambil call history'], 500);
        }
    }

    public function callCancel(Request $request)
    {
        $validated = $request->validate([
            'call_id' => 'required|integer|min:1',
        ]);

        try {
            $SG = new fiver();
            $response = json_decode($SG->callCancel((int) $validated['call_id']), true) ?: [];

            return response()->json($response);
        } catch (\Throwable $e) {
            Log::error('Error callCancel: ' . $e->getMessage());
            return response()->json(['status' => 0, 'msg' => 'Gagal membatalkan call'], 500);
        }
    }

    public function controlRtp(Request $request)
    {
        $validated = $request->validate([
            'provider' => 'required|string|max:64',
            'username' => 'required|string|max:255',
            'rtp' => 'required|integer|min:1|max:95',
        ]);

        try {
            $SG = new fiver();
            $response = json_decode($SG->controlRtp(
                $validated['provider'],
                $validated['username'],
                (int) $validated['rtp']
            ), true) ?: [];

            return response()->json($response);
        } catch (\Throwable $e) {
            Log::error('Error controlRtp: ' . $e->getMessage());
            return response()->json(['status' => 0, 'msg' => 'Gagal mengubah target RTP'], 500);
        }
    }

    /**
     * Fetch game history dari database
     */
     public function showForm(Request $request)
{
    $userSearch = trim((string) $request->query('user_search', ''));

    $users = \App\Models\User::query()
        ->select('id', 'name', 'extplayer')
        ->when($userSearch !== '', function ($query) use ($userSearch) {
            $query->where(function ($inner) use ($userSearch) {
                $inner->where('name', 'like', "%{$userSearch}%")
                    ->orWhere('extplayer', 'like', "%{$userSearch}%");
            });
        })
        ->orderBy('name')
        ->limit(100)
        ->get();

   return view('backoffice.history_play.history', compact('users', 'userSearch'));
}


    /**
     * Ambil data riwayat permainan dari API fiver
     */
    public function getGameHistory(Request $request)
    {
        $request->validate([
            'extplayer' => 'required|string',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
        ]);

        try {
            $fiver = new fiver();

            $username = $request->extplayer;
            $dateStart = $request->date_start ?: now()->subDays(7)->format('Y-m-d');
            $dateEnd   = $request->date_end ?: now()->format('Y-m-d');

            // 🔹 Panggil API untuk ambil riwayat permainan
            $responseRaw = $fiver->historyPlay($username, 'slot', $dateStart, $dateEnd, 1, 200);

            // 🔹 Decode hasil JSON
            $response = json_decode($responseRaw, true);

            // 🔹 Logging hasil untuk debugging
            Log::info('🎮 [FIVER HISTORY PLAY]', [
                'username' => $username,
                'date_start' => $dateStart,
                'date_end' => $dateEnd,
                'response' => $response
            ]);

            // 🔹 Jika API tidak valid atau kosong
            if (!is_array($response) || empty($response['data'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No game history found or invalid API response.',
                    'data' => []
                ]);
            }

            // 🔹 Format hasil agar cocok untuk DataTable
            $formattedData = collect($response['data'])->map(function ($item) {
                return [
                    'game_code' => $item['game_code'] ?? '-',
                    'bet_money' => $item['bet_money'] ?? 0,
                    'win_money' => $item['win_money'] ?? 0,
                    'txn_id' => $item['txn_id'] ?? '-',
                    'txn_type' => $item['txn_type'] ?? '-',
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $formattedData
            ]);
        } catch (\Throwable $e) {
            Log::error('❌ Error fetching FIVER history: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch game history. ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }
}
