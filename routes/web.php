<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GgrSiteController;
use App\Http\Controllers\GgrAmpController;
use App\Http\Controllers\GgrSeamlessController;
use App\Http\Controllers\SpinController;
use App\Http\Controllers\InjectController;
use App\Http\Controllers\AddGameController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\RefferalController;
use App\Http\Controllers\TurnoverController;


use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\UserDepositController;
use App\Http\Controllers\UserHistoryController;
use App\Http\Controllers\UserWithdrawController;
use App\Http\Controllers\UserPernyataanController;
use App\Http\Controllers\GetSaldoController;

use App\Http\Controllers\backoffice\BonusController;
use App\Http\Controllers\backoffice\BannerController;
use App\Http\Controllers\backoffice\DepositController;
use App\Http\Controllers\backoffice\GameAPIController;
use App\Http\Controllers\backoffice\GgrBackofficeController;
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

#region user ( no login allowed )


Route::get('/', [GgrSiteController::class, 'home']);

Route::get('/referral-register', [RefferalController::class, 'loadRefferal']);
Route::post('/referral-register/store', [RefferalController::class, 'store'])->name('store');

Route::get('/promotion', [GgrSiteController::class, 'promotion']);

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::redirect('/old-home', '/');
Route::get('/slots', [GgrSiteController::class, 'providers'])->defaults('type', 'slot');

Route::redirect('/complain-form', '/');

Route::get('/sports', [GgrSiteController::class, 'providers'])->defaults('type', 'SB');

Route::get('/spxkid', [GgrSiteController::class, 'notFound']);



Route::get('/casino', [GgrSiteController::class, 'providers'])->defaults('type', 'live');

Route::redirect('/p2p', '/slots');

Route::redirect('/fish-hunter', '/slots');

Route::redirect('/lottery', '/slots');

Route::get('/e-games', [GgrSiteController::class, 'providers'])->defaults('type', 'MN');

Route::redirect('/cockfight', '/casino');

// menu
Route::redirect('/memo', '/');

Route::redirect('/contact-us', '/');

Route::redirect('/complain', '/');

Route::redirect('/refferal', '/register');


Route::get('/username_phone', [GgrSiteController::class, 'usernamePhone']);
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
        Route::post('/backoffice/ggr/test-provider-api', [GgrBackofficeController::class, 'testProviderApi'])->name('backoffice.ggr.testProviderApi');
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
            Route::get('/clear-cache', [BackofficeController::class, 'clearCache'])->name('admin.clear-cache');

            Route::get('/voucher-lucky-spin', [VoucherController::class, 'index']);
            Route::post('/generate-voucher', [VoucherController::class, 'generateVoucher']);
            
            Route::post('/call-list', [GameSettingController::class, 'callList']);
            Route::post('/call-apply', [GameSettingController::class, 'callApply']);
            Route::get('/call-history', [GameSettingController::class, 'callHistory']);
            Route::post('/call-cancel', [GameSettingController::class, 'callCancel']);
            Route::post('/control-rtp', [GameSettingController::class, 'controlRtp']);
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
            Route::resource('/game_api', GameAPIController::class)->only(['index']);
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

    Route::get('/payment/status', [PaymentGatewayController::class, 'statusPayment'])->name('status.payment');
    Route::get('/qrcode/show', [PaymentGatewayController::class, 'showQrcode'])->name('qrcode.show');
    Route::get('/payment/qris', [PaymentGatewayController::class, 'paymentQris'])->name('bayar.qris');
    Route::get('/subGameLaunch', [GameController::class, 'subGameLaunch']);




    // ROUTE USER
    Route::GET('/profile', [ProfileController::class, 'index']);
    Route::POST('/turnover', [TurnoverController::class, 'turnOver']);
    Route::GET('/promo/saya', [TurnoverController::class, 'index']);
    Route::POST('/promo/bonus', [TurnoverController::class, 'getBonusPromotion']);
    Route::get('/saldo-refresh', [GetSaldoController::class, 'refresh']);
    Route::resource('/account/deposit', UserDepositController::class)->only(['index', 'store'])->names('account.deposit');
    Route::get('/account/withdrawal', [UserWithdrawController::class, 'index']);
    Route::POST('/withdrawal/user', [UserWithdrawController::class, 'store']);
    Route::get('/wdcuy', [UserWithdrawController::class, 'WD']);
    Route::resource('/account/lastDirectTransfer', UserHistoryController::class);
    Route::resource('/account/history', UserPernyataanController::class);

    Route::GET('/search-history', [RefferalController::class, 'searchHistory']);
    Route::GET('/search-history-today', [RefferalController::class, 'getTodaReff']);
});

Route::get('/ggr/provider/{slug}', [GgrSiteController::class, 'providerGames'])->name('ggr.provider');
Route::get('/slots/game_list/{slug}', [GgrSiteController::class, 'providerGames']);
Route::redirect('/game/sports/game_list/IBC', '/sports');
Route::get('/amp', [GgrAmpController::class, 'index'])->name('ggr.amp');
Route::post('/gold_api', [GgrSeamlessController::class, 'handle'])->name('ggr.seamless');
Route::get('/game_process/{game}', [GameController::class, 'connect_games'])->where('game', '.*');


Auth::routes();
Route::redirect('/home', '/')->name('home');
