<?php

use App\Models\Game;
use App\Models\User;
use App\Models\Saldo;
use App\Models\Banner;
use App\Http\Api\fiver;
use App\Models\Setting;
use App\Models\Game_api;
use App\Models\Game_list;
use App\Models\Transaksi;
use App\Models\Fiver_Game;
use Illuminate\Http\Request;
use App\Models\BannerPromosi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ActivateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GgrSiteController;
use App\Http\Controllers\GameCatalogController;
use App\Http\Controllers\SpinController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\InjectController;
use App\Http\Controllers\AddGameController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\RefferalController;
use App\Http\Controllers\TurnoverController;


use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\Api\WzGamesController;
use App\Http\Controllers\UserDepositController;
use App\Http\Controllers\UserHistoryController;
use App\Http\Controllers\UserWithdrawController;
use App\Http\Controllers\UserPernyataanController;
use App\Http\Controllers\backoffice\IconController;
use App\Http\Controllers\GetSaldoController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\backoffice\LogoController;
use App\Http\Controllers\backoffice\BonusController;
use App\Http\Controllers\RegisterRefferalController;
use App\Http\Controllers\backoffice\BannerController;
use App\Http\Controllers\backoffice\DepositController;
use App\Http\Controllers\backoffice\GameAPIController;
use App\Http\Controllers\backoffice\GgrBackofficeController;
use App\Http\Controllers\backoffice\PromosiController;
use App\Http\Controllers\backoffice\WithdrawController;
use App\Http\Controllers\backoffice\BackofficeController;
use App\Http\Controllers\backoffice\DatamemberController;
use App\Http\Controllers\backoffice\PernyataanController;
use App\Http\Controllers\backoffice\DepositbankController;
use App\Http\Controllers\backoffice\GameSettingController;
use App\Http\Controllers\backoffice\HistoryPlayController;
use App\Http\Controllers\backoffice\ProfilAdminController;
use App\Http\Controllers\backoffice\BannerPromosiController;
use App\Http\Controllers\backoffice\PengaturanSaldoController;
use App\Http\Controllers\backoffice\HistoritransaksiController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/validate-voucher', [SpinController::class, 'validateVoucher']);
Route::get('/spin', [SpinController::class, 'index']);
Route::POST('/save-prize', [SpinController::class, 'spinPrize']);

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});


#region user ( no login allowed )


Route::get('/', [GgrSiteController::class, 'home']);

Route::get('/referral-register', [RefferalController::class, 'loadRefferal']);
Route::post('/referral-register/store', [RefferalController::class, 'store'])->name('store');

 //Route::get('/activate', [ActivateController::class, 'index'])->name('activate.page');
// Route::post('/activate/post', [ActivateController::class, 'activate'])->name('activate.post');
// Route::get('/activate/verify', [ActivateController::class, 'verify']);

Route::get('/promotion', function () {
    $banners = BannerPromosi::all();
    return view('promotion', compact('banners'));
});

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::get('/old-home', [HomeController::class, 'index']);
Route::get('/slots', [GgrSiteController::class, 'providers'])->defaults('type', 'slot');

Route::get('/complain-form', function () {
    return view('content.complain');
});

Route::get('/sports', [GgrSiteController::class, 'providers'])->defaults('type', 'SB');

Route::get('/spxkid', function () {
    abort(404);
});



Route::get('/casino', [GgrSiteController::class, 'providers'])->defaults('type', 'live');

Route::get('/p2p', [GameCatalogController::class, 'category'])->defaults('slug', 'p2p');

Route::get('/fish-hunter', [GameCatalogController::class, 'category'])->defaults('slug', 'fish-hunter');

Route::get('/lottery', [GameCatalogController::class, 'category'])->defaults('slug', 'lottery');

Route::get('/e-games', [GgrSiteController::class, 'providers'])->defaults('type', 'MN');

Route::get('/cockfight', function () {
    return view('games.cockfight');
});

// menu
Route::get('/memo', function () {
    return view('memo');
});

Route::get('/contact-us', function () {
    return view('contact-us');
});

Route::get('/complain', function () {
    return view('content.complain');
});

Route::get('/refferal', function () {
    return view('refferal');
});


Route::get('/username_phone', function (Request $request) {

    $username = addslashes(base64_decode($request->username));
    $phone = addslashes(base64_decode($request->phone));

    // check  current username
    $data_name = User::where([
        'name' => $username
    ])->first();

    // check current phone number
    $data_phone = User::where([
        'telp' => $phone
    ])->first();


    // true is avail
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'username' => empty($data_name),
        'phone' => empty($data_phone)
    ]);
});
Route::get('/admins', [AdminLoginController::class, 'index']);
Route::POST('/admins/login', [AdminLoginController::class, 'auth'])->name('admin.login');
Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/get-balance', [BackofficeController::class, 'agentbalance']);
        // ROUTE ADMINISTRATOR (Input Trans Only)
        Route::get('/total-bersih-harian', [BackofficeController::class, 'getTotalBersihHarian']);
        Route::resource('/deposit', DepositController::class)->only(['index', 'store']);
        Route::resource('/withdraw', WithdrawController::class);
        Route::resource('/histori_transaksi', HistoritransaksiController::class);
        Route::get('/backoffice/ggr', [GgrBackofficeController::class, 'index'])->name('backoffice.ggr');
        Route::post('/backoffice/ggr/sync-providers', [GgrBackofficeController::class, 'syncProviders'])->name('backoffice.ggr.syncProviders');
        Route::post('/backoffice/ggr/sync-games', [GgrBackofficeController::class, 'syncGames'])->name('backoffice.ggr.syncGames');
        Route::post('/backoffice/ggr/sync-provider/{code}', [GgrBackofficeController::class, 'syncProvider'])->name('backoffice.ggr.syncProvider');
        Route::resource('/backoffice', BackofficeController::class);

        Route::resource('/profil_admin', ProfilAdminController::class);
        Route::put('/user-deposit/aksi/{id}', [UserDepositController::class, 'action']);
        Route::put('/user-withdraw/aksi/{id}', [UserWithdrawController::class, 'aksi']);
        Route::resource('/pengaturan_saldo', PengaturanSaldoController::class);
        Route::resource('/data_member', DatamemberController::class);
        Route::post('/data_member/create', [DatamemberController::class, 'create'])->name('create.member');
        Route::put('/data_member/update/{id}', [DatamemberController::class, 'update'])->name('update.member');
        Route::resource('/bank', DepositbankController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('/inject-saldo', InjectController::class)->only(['index', 'update']);
        Route::put('/saldo/update/{id}', [InjectController::class, 'update'])->name('saldo.update');
        Route::get('/update/saldo', [GetSaldoController::class, 'saldo']);
        Route::put('/deposit/reject/{id}', [DepositController::class, 'reject'])->name('depo.reject');
        Route::put('/deposit/confirm/{id}', [DepositController::class, 'confirm'])->name('depo.confirm');
        Route::put('/withdraw/reject/{id}', [WithdrawController::class, 'reject'])->name('withdraw.reject');
        Route::put('/withdraw/confirm/{id}', [WithdrawController::class, 'confirm'])->name('withdraw.confirm');

        Route::put('/update/api/sg', [SettingController::class, 'apiSG'])->name('api.sg');
        Route::put('/update/api/nx', [SettingController::class, 'apiNX'])->name('api.nx');
        Route::put('/update/api/wsg', [SettingController::class, 'apiWSG'])->name('api.wsg');
        Route::put('/update/api/ng', [SettingController::class, 'apiNG'])->name('api.ng');

        Route::group(['middleware' => 'dev_mode'], function () {
            Route::get('/voucher-lucky-spin', [VoucherController::class, 'index']);
            Route::post('/generate-voucher', [VoucherController::class, 'generateVoucher']);
            
            Route::post('/call-list', [GameSettingController::class, 'callList']);
            Route::post('/call-apply', [GameSettingController::class, 'callApply']);
            Route::resource('/deposit_bank', DepositbankController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::post('/fetch-game-history', [HistoryPlayController::class, 'getGameHistory'])
    ->name('fetch.game.history');

Route::get('/history-play/user', [HistoryPlayController::class, 'showForm'])
    ->name('history.play.user');


            Route::resource('/pernyataan', PernyataanController::class);
            Route::resource('/banner', BannerController::class);
            Route::resource('/banner_promosi', BannerPromosiController::class);
            Route::resource('/bonus', BonusController::class);
            Route::resource('/game_setting', GameSettingController::class)->only(['index', 'update']);
            Route::resource('/game_api', GameAPIController::class);
            Route::get('/add-games', [AddGameController::class, 'index']);
            Route::delete('/delete-games', [AddGameController::class, 'deleteGames']);
            Route::get('/game_setting_lock', [GameSettingController::class, 'lock']);
            Route::get('/game_setting_unlock', [GameSettingController::class, 'unlock']);

            Route::resource('/setting', SettingController::class)->except(['update']);
            Route::put('/update/website', [SettingController::class, 'updateWebsite'])->name('update.website');
            Route::put('/update/contact', [SettingController::class, 'updateContact'])->name('update.contact');
            Route::put('/update/appearance', [SettingController::class, 'updateAppearance'])->name('update.appearance');
            Route::put('/update/popup', [SettingController::class, 'updatePopup'])->name('update.popup');
            Route::put('/update/gateway', [SettingController::class, 'updateGateway'])->name('update.gateway');
            Route::put('/update/depowd', [SettingController::class, 'updateWDDEPO'])->name('update.depowd');
            
        });
    });

    Route::post('/create-payment', [PaymentGatewayController::class, 'createPayment'])->name('create-payment');
    Route::get('/payment/status', [PaymentGatewayController::class, 'statusPayment'])->name('status.payment');
    Route::get('/qrcode/show', function(Request $request) {
        $decodedUrl = base64_decode($request->encodedUrl);
        return redirect($decodedUrl);
    })->name('qrcode.show');
    Route::get('/payment/qris', [PaymentGatewayController::class, 'paymentQris'])->name('bayar.qris');
    Route::post('/payment/create', [PaymentGatewayController::class, 'createPayment'])->name('payment.create');
    Route::post('/jayapay/create', [PaymentGatewayController::class, 'createPayment'])->name('jayapay.create');
    Route::post('/jayapay/payment', [PaymentGatewayController::class, 'createPayment'])->name('jayapay.payment');
    Route::get('/subGameLaunch', function (Request $request) {
        $validated = $request->validate([
            'game_code' => 'required|string',
            'provider' => 'required|string',
        ]);

        $fiver = new fiver();
        $response = $fiver->opengame(
            Auth::user()->name,
            $validated['game_code'],
            $validated['provider'],
            'id'
        );

        $data = json_decode($response, true);

        if (isset($data['status']) && in_array($data['status'], [1, '1', 'success', 'SUCCESS'], true) && !empty($data['launch_url'])) {
            return redirect()->away($data['launch_url']);
        }

        \Log::error('Fiver API error on subGameLaunch', [
            'user' => Auth::user()->name,
            'request' => $validated,
            'response' => $response,
        ]);

        return back()->with('error', 'Permainan belum bisa dibuka saat ini. Silakan coba lagi beberapa saat.');
    });




    // ROUTE USER
    Route::GET('/profile', [ProfileController::class, 'index']);
    Route::POST('/turnover', [TurnoverController::class, 'turnOver']);
    Route::GET('/promo/saya', [TurnoverController::class, 'index']);
    Route::POST('/promo/bonus', [TurnoverController::class, 'getBonusPromotion']);
    Route::get('/saldo-refresh', function () {
        $localSaldo = (float) (Saldo::where('user_id', Auth::id())->value('saldo') ?? 0);

        try {
            $SG = new fiver();
            $act = json_decode($SG->userbalance(Auth::user()->name));
            $apiBalance = data_get($act, 'user.balance');

            if ($apiBalance !== null && is_numeric($apiBalance)) {
                return response()->json([
                    'error' => false,
                    'balance' => (float) $apiBalance,
                    'source' => 'api',
                ]);
            }
        } catch (\Throwable $e) {
            \Log::warning('Saldo refresh API gagal', [
                'user_id' => Auth::id(),
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'error' => false,
            'balance' => $localSaldo,
            'source' => 'local',
        ]);
    });
    Route::resource('/account/deposit', UserDepositController::class)->only(['index', 'store']);
    Route::get('/account/withdrawal', [UserWithdrawController::class, 'index']);
    Route::POST('/withdrawal/user', [UserWithdrawController::class, 'store']);
    Route::get('/wdcuy', [UserWithdrawController::class, 'WD']);
    Route::resource('/account/lastDirectTransfer', UserHistoryController::class);
    Route::resource('/account/history', UserPernyataanController::class);

    Route::get('/ajaxprofileEdit', function () {
        return view('profile_edit');
    });

    Route::get('/ajaxchgPass', function () {
        return view('change_password');
    });

    
    Route::get('/getBal', function () {
        return view('get_balance');
    });
    Route::get('/ajaxIDNBal', function () {
        return view('get_balance');
    });

    Route::GET('/search-history', [RefferalController::class, 'searchHistory']);
    Route::GET('/search-history-today', [RefferalController::class, 'getTodaReff']);
});

Route::get('/ggr/provider/{slug}', [GgrSiteController::class, 'providerGames'])->name('ggr.provider');
Route::get('/slots/game_list/{slug}', [GgrSiteController::class, 'providerGames']);
Route::get('/game/sports/game_list/IBC', [GameCatalogController::class, 'category'])->defaults('slug', 'IBC');
Route::get('/game_process/{game}', [GameController::class, 'connect_games'])->where('game', '.*');
Route::post('/jayapay/callback', [PaymentGatewayController::class, 'callback']);


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
