<?php

namespace App\Http\Controllers;

use App\Models\Api;
use App\Models\Setting;
use App\Support\SafeHtml;
use App\Support\ThemePalette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        $setting = $this->settingRecord();
        $api = $this->apiRecord();
        $themePresets = ThemePalette::presets();
        $activeTheme = ThemePalette::resolve($setting->themes ?? null);
        $topPayment = [
            'merchant_code' => config('jayapay.merchant_code'),
            'api_url' => config('jayapay.api_url'),
            'query_url' => config('jayapay.query_url'),
            'notify_url' => config('jayapay.notify_url'),
            'private_key_path' => config('jayapay.private_key_path', 'storage/app/toppayment_private.pem'),
            'public_key_path' => config('jayapay.public_key_path', 'storage/app/toppayment_public.pem'),
            'private_key_fingerprint' => $this->keyFingerprint(base_path(config('jayapay.private_key_path', 'storage/app/toppayment_private.pem')), true),
            'public_key_fingerprint' => $this->keyFingerprint(base_path(config('jayapay.public_key_path', 'storage/app/toppayment_public.pem')), false),
        ];

        return view('backoffice.setting.setting', compact('setting', 'api', 'topPayment', 'themePresets', 'activeTheme'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function show(Setting $setting) {}
    public function edit(Setting $setting) {}

    public function updateWebsite(Request $request)
    {
        $request->validate([
            'nama_web' => 'required|string|max:120',
            'telp' => 'nullable|string|max:30',
            'metaKeyword' => 'nullable|string|max:500',
            'metaDescription' => 'nullable|string|max:500',
            'metaSocial' => 'nullable|string|max:500',
            'seoBanner' => 'nullable|file|mimes:png,jpg,jpeg,webp,gif|max:4096',
            'maintenance_mode' => 'required|in:0,1',
        ]);

        $web = $this->settingRecord();
        $web->nama_web = $request->nama_web;
        $web->telp = $request->telp;
        $web->seo_meta_keywords = $request->metaKeyword;
        $web->seo_description = $request->metaDescription;
        $web->seo_social_description = $request->metaSocial;
        $web->maintenance_mode = $request->maintenance_mode;

        if ($request->hasFile('seoBanner')) {
            $web->seo_banner = $request->file('seoBanner')->store('appearance/seo', 'public');
        }

        $web->save();

        return redirect()->back()->with('success', 'Pengaturan website berhasil diperbarui.');
    }

    public function updateContact(Request $request)
    {
        $contact = $this->settingRecord();
        $contact->wa = $request->input('wa');
        $contact->tele = $request->input('tele');
        $contact->live_chat = $request->input('live_chat');
        $contact->save();

        return redirect()->back()->with('success', 'Kontak berhasil diperbarui.');
    }

    public function updateAppearance(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|file|mimes:png,jpg,jpeg,webp,gif|max:4096',
            'favicon' => 'nullable|file|mimes:png,jpg,jpeg,webp,gif,ico|max:2048',
            'running_text' => 'nullable|string|max:255',
            'template' => 'nullable|string|max:50',
            'theme' => 'nullable|string|max:50',
            'theme_custom' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $appearance = $this->settingRecord();
        $theme = $request->theme === 'custom' ? $request->theme_custom : $request->theme;
        if (filled($theme) && !isset(ThemePalette::presets()[$theme]) && !preg_match('/^#[0-9A-Fa-f]{6}$/', (string) $theme)) {
            return redirect()->back()->withErrors(['theme' => 'Tema tidak valid.'])->withInput();
        }

        $appearance->themes = $theme ?: 'theme-1';
        $appearance->template = $request->template;
        $appearance->running_text = $request->running_text;

        if ($request->hasFile('logo')) {
            $appearance->logo = $request->file('logo')->store('appearance/logo', 'public');
        }

        if ($request->hasFile('favicon')) {
            $appearance->favicon = $request->file('favicon')->store('appearance/favicon', 'public');
        }

        $appearance->save();

        return redirect()->back()->with('success', 'Tampilan berhasil diperbarui.');
    }

    public function updatePopup(Request $request)
    {
        $request->validate([
            'popup' => 'nullable|file|mimes:png,jpg,jpeg,webp,gif,mp4,webm|max:8192',
            'popup_enabled' => 'required|in:0,1',
            'popup_title' => 'nullable|string|max:120',
            'popup_bg' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'msg_popup' => 'nullable|string',
            'popup_cta_text' => 'nullable|string|max:80',
            'popup_cta_url' => 'nullable|string|max:255',
        ]);

        $popup = $this->settingRecord();
        $popup->popup_enabled = (int) $request->popup_enabled;
        $popup->popup_title = $request->popup_title;
        $popup->msg_popup = SafeHtml::popup($request->msg_popup);
        $popup->popup_bg = $request->popup_bg ?: '#111111';
        $popup->popup_cta_text = $request->popup_cta_text;
        $popup->popup_cta_url = $request->popup_cta_url;

        if ($request->hasFile('popup')) {
            $popup->popup = $request->file('popup')->store('appearance/popup', 'public');
        }

        $popup->save();

        return redirect()->back()->with('success', 'Popup berhasil diperbarui.');
    }

    public function updateGateway(Request $request)
    {
        $request->validate([
            'merchantCode' => 'required|string|max:80',
            'apiUrl' => 'required|url|max:255',
            'queryUrl' => 'required|url|max:255',
            'notifyUrl' => 'required|url|max:255',
            'privateKeyPath' => 'required|string|max:255',
            'publicKeyPath' => 'required|string|max:255',
            'merchantPrivateKey' => 'nullable|string',
            'platformPublicKey' => 'nullable|string',
            'statusGateway' => 'required|in:0,1',
        ]);

        $privatePath = $this->safeStoragePath($request->privateKeyPath);
        $publicPath = $this->safeStoragePath($request->publicKeyPath);

        if (filled($request->merchantPrivateKey)) {
            $privatePem = $this->normalizePem($request->merchantPrivateKey, 'PRIVATE KEY');
            $privateKey = openssl_pkey_get_private($privatePem);
            if (!$privateKey) {
                return redirect()->back()->withErrors(['merchantPrivateKey' => 'Merchant private key tidak valid.'])->withInput();
            }
            unset($privateKey);

            File::put(base_path($privatePath), $privatePem);
            @chmod(base_path($privatePath), 0600);
        }

        if (filled($request->platformPublicKey)) {
            $publicPem = $this->normalizePem($request->platformPublicKey, 'PUBLIC KEY');
            $publicKey = openssl_pkey_get_public($publicPem);
            if (!$publicKey) {
                return redirect()->back()->withErrors(['platformPublicKey' => 'Platform public key tidak valid.'])->withInput();
            }
            unset($publicKey);

            File::put(base_path($publicPath), $publicPem);
            @chmod(base_path($publicPath), 0644);
        }

        $gateway = $this->settingRecord();
        $gateway->url_gateway = $request->apiUrl;
        $gateway->apikey_gateway = $request->merchantCode;
        $gateway->callback_url = $request->notifyUrl;
        $gateway->qris_status = (int) $request->statusGateway;
        $gateway->save();

        $this->writeEnvValues([
            'TOPPAYMENT_MERCHANT_CODE' => $request->merchantCode,
            'TOPPAYMENT_PRIVATE_KEY_PATH' => $privatePath,
            'TOPPAYMENT_PUBLIC_KEY_PATH' => $publicPath,
            'TOPPAYMENT_API_URL' => $request->apiUrl,
            'TOPPAYMENT_QUERY_URL' => $request->queryUrl,
            'TOPPAYMENT_NOTIFY_URL' => $request->notifyUrl,
            'JAYAPAY_MERCHANT_CODE' => $request->merchantCode,
            'JAYAPAY_PRIVATE_KEY_PATH' => $privatePath,
            'JAYAPAY_PUBLIC_KEY_PATH' => $publicPath,
            'JAYAPAY_API_URL' => $request->apiUrl,
            'JAYAPAY_QUERY_URL' => $request->queryUrl,
            'JAYAPAY_NOTIFY_URL' => $request->notifyUrl,
        ]);

        Artisan::call('config:clear');
        Artisan::call('config:cache');

        return redirect()->back()->with('success', 'Payment gateway berhasil diperbarui.');
    }

    public function updateWDDEPO(Request $request)
    {
        $request->validate([
            'minim_depo' => 'required|integer|min:1000',
            'minim_wd' => 'required|integer|min:1000',
            'maks_wd' => 'required|integer|gte:minim_wd',
            'deposit_delay' => 'required|integer|min:1|max:168',
        ]);

        $dpwd = $this->settingRecord();
        $dpwd->minimal_depo = (int) $request->minim_depo;
        $dpwd->minimal_wd = (int) $request->minim_wd;
        $dpwd->maksimal_wd = (int) $request->maks_wd;
        $dpwd->deposit_delay = (int) $request->deposit_delay;
        $dpwd->save();

        return redirect()->back()->with('success', 'Pengaturan deposit dan withdraw berhasil diperbarui.');
    }

    public function apiSG(Request $request)
    {
        $SG = $this->apiRecord();
        $SG->sg_agent_code = $request->input('sgAgentCode');
        $SG->sg_sign = $request->input('sgSignature');
        $SG->sg_endpoint = $request->input('sgEndpoint');
        $SG->sg_status = $request->input('sgStatus');
        $SG->save();

        return redirect()->back()->with('success', 'Softgaming API berhasil diperbarui.');
    }

    public function apiNX(Request $request)
    {
        $validated = $request->validate([
            'nxAgentCode' => 'required|string|max:100',
            'nxToken' => 'required|string|max:255',
            'nxSecret' => 'nullable|string|max:255',
            'nxEndpoint' => 'required_if:nxStatus,1|nullable|url|max:255',
            'nxStatus' => 'required|in:0,1',
        ]);

        $NX = $this->apiRecord();
        $NX->nx_agent_code = trim($validated['nxAgentCode']);
        $NX->nx_token = trim($validated['nxToken']);
        $NX->nx_secret = trim((string) ($validated['nxSecret'] ?? ''));
        $NX->nx_endpoint = trim((string) ($validated['nxEndpoint'] ?? ''));
        $NX->nx_status = (int) $validated['nxStatus'];
        $NX->save();

        return redirect()->back()->with('success', 'Nexus API berhasil diperbarui.');
    }

    public function apiWSG(Request $request)
    {
        $WSG = $this->apiRecord();
        $WSG->wsg_agent_code = $request->input('wsgAgentCode');
        $WSG->wsg_token = $request->input('wsgToken');
        $WSG->wsg_endpoint = $request->input('wsgEndpoint');
        $WSG->wsg_status = $request->input('wsgStatus');
        $WSG->save();

        return redirect()->back()->with('success', 'World Slot Game API berhasil diperbarui.');
    }

    public function apiNG(Request $request)
    {
        $NG = $this->apiRecord();
        $NG->ng_agent_code = $request->input('ngAgentCode');
        $NG->ng_signature = $request->input('ngSignature');
        $NG->ng_endpoint = $request->input('ngEndpoint');
        $NG->ng_status = $request->input('ngStatus');
        $NG->save();

        return redirect()->back()->with('success', 'N-Gaming API berhasil diperbarui.');
    }

    public function destroy(Setting $setting) {}

    private function writeEnvValues(array $values): void
    {
        $path = base_path('.env');
        $content = File::exists($path) ? File::get($path) : '';

        foreach ($values as $key => $value) {
            $line = $key . '=' . $this->formatEnvValue((string) $value);
            if (preg_match('/^' . preg_quote($key, '/') . '=.*/m', $content)) {
                $content = preg_replace('/^' . preg_quote($key, '/') . '=.*/m', $line, $content);
            } else {
                $content = rtrim($content) . PHP_EOL . $line . PHP_EOL;
            }
        }

        File::put($path, $content);
    }

    private function settingRecord(): Setting
    {
        return Setting::firstOrNew(['id' => 1], [
            'nama_web' => 'ireng17',
            'telp' => null,
            'wa' => null,
            'tele' => null,
            'running_text' => 'Selamat datang di IRENG17.',
            'popup_bg' => '#111111',
            'template' => 'main',
            'live_chat_js' => '',
            'msg_popup' => 'Selamat datang di IRENG17.',
            'themes' => 'theme-1',
            'maintenance_mode' => 0,
            'deposit_delay' => 24,
            'url_gateway' => 'https://global-id-openapi.toppayment.com/id/pay/prePay',
            'apikey_gateway' => (string) config('jayapay.merchant_code', ''),
            'callback_url' => config('jayapay.notify_url') ?: url('/api/jayapay/callback'),
            'qris_status' => 1,
            'minimal_depo' => 20000,
            'minimal_wd' => 50000,
            'maksimal_wd' => 100000000,
        ]);
    }

    private function apiRecord(): Api
    {
        return Api::firstOrNew(['id' => 1], [
            'nx_agent_code' => (string) config('services.ggr.agent_code', ''),
            'nx_token' => (string) config('services.ggr.agent_token', ''),
            'nx_secret' => '',
            'nx_endpoint' => '',
            'nx_status' => 0,
            'sg_status' => 0,
            'wsg_status' => 0,
            'ng_status' => 0,
        ]);
    }

    private function formatEnvValue(string $value): string
    {
        if ($value === '') {
            return '""';
        }

        if (preg_match('/\s|#|"|\'/', $value)) {
            return '"' . str_replace(['\\', '"'], ['\\\\', '\\"'], $value) . '"';
        }

        return $value;
    }

    private function normalizePem(string $value, string $type): string
    {
        $value = trim($value);
        if (str_contains($value, '-----BEGIN')) {
            return $value . PHP_EOL;
        }

        $body = chunk_split(preg_replace('/\s+/', '', $value), 64, PHP_EOL);

        return "-----BEGIN {$type}-----" . PHP_EOL
            . $body
            . "-----END {$type}-----" . PHP_EOL;
    }

    private function safeStoragePath(string $path): string
    {
        $path = trim(str_replace('\\', '/', $path));
        $path = ltrim($path, '/');

        if (!str_starts_with($path, 'storage/app/')) {
            $path = 'storage/app/' . basename($path);
        }

        File::ensureDirectoryExists(dirname(base_path($path)), 0755, true);

        return $path;
    }

    private function keyFingerprint(string $path, bool $private): ?string
    {
        if (!File::exists($path)) {
            return null;
        }

        $content = File::get($path);
        $key = $private ? openssl_pkey_get_private($content) : openssl_pkey_get_public($content);

        if (!$key) {
            return null;
        }

        $details = openssl_pkey_get_details($key);
        unset($key);

        if (empty($details['key'])) {
            return null;
        }

        return substr(hash('sha256', $details['key']), 0, 16);
    }
}
