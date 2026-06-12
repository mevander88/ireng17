@extends('backoffice.layouts.main')

@section('content')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
    @if (isset($errors) && $errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal menyimpan',
                text: '{{ $errors->first() }}',
            });
        </script>
    @endif
    <div class="mt-3 bo-setting-page">
        <div class="col-12 col-sm-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
                                href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home"
                                aria-selected="true">Info Website</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill"
                                href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile"
                                aria-selected="false">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill"
                                href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages"
                                aria-selected="false">Appearance</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-three-settings-tab" data-toggle="pill"
                                href="#custom-tabs-three-settings" role="tab" aria-controls="custom-tabs-three-settings"
                                aria-selected="false">Pop Up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-three-payment-tab" data-toggle="pill"
                                href="#custom-tabs-three-payment" role="tab" aria-controls="custom-tabs-three-payment"
                                aria-selected="false">Payment Gateway</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-three-deposit-withdraw-tab" data-toggle="pill"
                                href="#custom-tabs-three-deposit-withdraw" role="tab"
                                aria-controls="custom-tabs-three-deposit-withdraw" aria-selected="false">Setting DP-WD</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-three-api-tab" data-toggle="pill"
                                href="#custom-tabs-three-api" role="tab" aria-controls="custom-tabs-three-api"
                                aria-selected="false">Setting API</a>
                        </li>

                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-three-tabContent">
                        <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel"
                            aria-labelledby="custom-tabs-three-home-tab">
                            <form action="{{ route('update.website') }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    @php
                                        $seoBannerPreview = !empty($setting->seo_banner) ? asset('storage/' . $setting->seo_banner) : asset('assets/images/provider-covers/spribe-aviator.svg');
                                    @endphp
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <strong>SEO aktif sekarang:</strong>
                                            description {{ filled($setting->seo_description) ? 'custom aktif' : 'default' }},
                                            social banner {{ filled($setting->seo_banner) ? 'custom (' . $setting->seo_banner . ')' : 'default' }}.
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-text text-muted">Nama Website
                                                :</label>
                                            <input name="nama_web" type="text" class="form-control"
                                                placeholder="Nama Website" value="{{ $setting->nama_web }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-text text-muted">No TLP:</label>
                                            <input name="telp" type="text" class="form-control"
                                                placeholder="Nomor Telepon format +62" value="{{ $setting->telp }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-text text-muted">SEO Meta Keyword
                                                :</label>
                                            <input name="metaKeyword" type="text" class="form-control" placeholder=""
                                                value="{{ $setting->seo_meta_keywords }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-text text-muted">SEO Description
                                                :</label>
                                            <input name="metaDescription" type="text" class="form-control"
                                                placeholder="" value="{{ $setting->seo_description }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-text text-muted">SEO Social Meta
                                                Description :</label>
                                            <input name="metaSocial" type="text" class="form-control" placeholder=""
                                                value="{{ $setting->seo_social_description }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-text text-muted">Status Website :
                                                @if ($setting->maintenance_mode == 0)
                                                    <strong class="admin-status-text is-online"> Online</strong>
                                                @else
                                                    <strong class="admin-status-text is-maintenance"> Maintenance</strong>
                                                @endif
                                            </label>
                                            <select class="form-control" name="maintenance_mode" required>
                                                <option value="0" {{ (int) $setting->maintenance_mode === 0 ? 'selected' : '' }}>Normal</option>
                                                <option value="1" {{ (int) $setting->maintenance_mode === 1 ? 'selected' : '' }}>Maintenance On</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-text text-muted">SEO Social Banner :</label>
                                            <div class="bo-setting-preview mb-2">
                                                <img src="{{ $seoBannerPreview }}" alt="SEO banner {{ $setting->nama_web }}" loading="lazy">
                                            </div>
                                            <input name="seoBanner" type="file" class="form-control uploads"
                                                accept="image/png, image/jpeg, image/webp, image/gif">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel"
                            aria-labelledby="custom-tabs-three-profile-tab">
                            <form action="{{ route('update.contact') }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-text text-muted">No Whatsapp :</label>
                                            <input name="wa" type="text" class="form-control"
                                                value="{{ $setting->wa }}" placeholder="Nomor Whatsapp format +62">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-text text-muted">Username Telegram :</label>
                                            <input name="tele" type="text" class="form-control"
                                                value="{{ $setting->tele }}" placeholder="Username Telegram">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-text text-muted">Live Chat
                                                :</label>
                                            <textarea name="live_chat" type="text" class="form-control" placeholder="Live Chat">{{ $setting->live_chat }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel"
                            aria-labelledby="custom-tabs-three-messages-tab">
                            <form action="{{ route('update.appearance') }}" method="POST"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    @php
                                        $logoPreview = !empty($setting->logo) ? asset('storage/' . $setting->logo) : asset('assets/images/logo.png');
                                        $faviconPreview = !empty($setting->favicon) ? asset('storage/' . $setting->favicon) : asset('favicon.ico');
                                        $themeStoredValue = $setting->themes ?: 'theme-1';
                                        $isCustomTheme = $activeTheme['key'] === 'custom';
                                    @endphp
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <strong>Tema aktif sekarang:</strong>
                                            {{ $activeTheme['name'] }} ({{ $themeStoredValue }}).
                                            <span class="ml-2 d-inline-flex align-items-center" style="gap:6px;vertical-align:middle;">
                                                <span title="Primary" style="display:inline-block;width:18px;height:18px;border-radius:4px;background:{{ $activeTheme['primary_solid'] }};border:1px solid rgba(0,0,0,.18);"></span>
                                                <span title="Deep" style="display:inline-block;width:18px;height:18px;border-radius:4px;background:{{ $activeTheme['primary_deep'] }};border:1px solid rgba(0,0,0,.18);"></span>
                                                <span title="Gold" style="display:inline-block;width:18px;height:18px;border-radius:4px;background:{{ $activeTheme['gold'] }};border:1px solid rgba(0,0,0,.18);"></span>
                                                <span title="Soft" style="display:inline-block;width:18px;height:18px;border-radius:4px;background:{{ $activeTheme['gold_soft'] }};border:1px solid rgba(0,0,0,.18);"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Logo Website :</label>
                                        <div class="mb-2">
                                            <img src="{{ $logoPreview }}" alt="Logo {{ $setting->nama_web }}" style="max-height:56px;max-width:220px;background:#111;border:1px solid #333;border-radius:8px;padding:8px;">
                                        </div>
                                        <input name="logo" type="file" class="form-control uploads"
                                            accept="image/png, image/jpeg, image/webp, image/gif">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Favicon :</label>
                                        <div class="mb-2">
                                            <img src="{{ $faviconPreview }}" alt="Favicon {{ $setting->nama_web }}" style="width:40px;height:40px;object-fit:contain;background:#111;border:1px solid #333;border-radius:8px;padding:6px;">
                                        </div>
                                        <input name="favicon" type="file" class="form-control uploads"
                                            accept="image/png, image/jpeg, image/webp, image/gif, image/x-icon">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Running Text :</label>
                                        <input name="running_text" type="text" class="form-control"
                                            value="{{ $setting->running_text }}" placeholder="Running Text">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Template :</label>
                                        <select name="template" class="form-control">
                                            <option value="main" {{ $setting->template == 'main' ? 'selected' : '' }}>Onix/UG</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="Theme" class="form-text text-muted">Theme :</label>
                                            <select name="theme" class="form-control">
                                                @foreach ($themePresets as $themeKey => $theme)
                                                    <option value="{{ $themeKey }}" {{ $activeTheme['key'] === $themeKey ? 'selected' : '' }}>
                                                        {{ $theme['name'] }}
                                                    </option>
                                                @endforeach
                                                <option value="custom" {{ $isCustomTheme ? 'selected' : '' }}>Custom Accent</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-text text-muted">Custom Accent :</label>
                                            <input name="theme_custom" type="color" class="form-control"
                                                value="{{ $isCustomTheme ? $themeStoredValue : $activeTheme['gold'] }}"
                                                style="height:38px;padding:4px;">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-three-settings" role="tabpanel"
                            aria-labelledby="custom-tabs-three-settings-tab">
                            <form action="{{ route('update.popup') }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    @php
                                        $popupPreview = !empty($setting->popup) ? asset('storage/' . $setting->popup) : null;
                                        $popupExtension = $setting->popup ? strtolower(pathinfo($setting->popup, PATHINFO_EXTENSION)) : null;
                                        $popupEnabled = (int) ($setting->popup_enabled ?? 1);
                                    @endphp
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <strong>Popup aktif sekarang:</strong>
                                            status {{ $popupEnabled === 1 ? 'aktif' : 'nonaktif' }},
                                            title {{ filled($setting->popup_title) ? $setting->popup_title : strtoupper($setting->nama_web ?? 'ireng17') }},
                                            media {{ $setting->popup ? 'custom (' . $setting->popup . ')' : 'default logo' }},
                                            background {{ $setting->popup_bg ?: '#111111' }},
                                            text {{ filled($setting->msg_popup) ? 'custom aktif' : 'default' }}.
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-text text-muted">Pop Up Banner :</label>
                                            @if ($popupPreview)
                                                <div class="bo-setting-preview is-popup mb-2">
                                                    @if (in_array($popupExtension, ['mp4', 'webm']))
                                                        <video src="{{ $popupPreview }}" muted controls></video>
                                                    @else
                                                        <img src="{{ $popupPreview }}" alt="Popup banner">
                                                    @endif
                                                </div>
                                            @endif
                                            <input name="popup" type="file" class="form-control uploads"
                                                accept="image/png, image/jpeg, image/webp, image/gif, video/mp4, video/webm">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-text text-muted">Status Popup :</label>
                                            <select class="form-control mb-3" name="popup_enabled" required>
                                                <option value="1" {{ $popupEnabled === 1 ? 'selected' : '' }}>Aktif</option>
                                                <option value="0" {{ $popupEnabled !== 1 ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                            <label class="form-text text-muted">Popup Title :</label>
                                            <input class="form-control mb-3" type="text" name="popup_title"
                                                value="{{ old('popup_title', $setting->popup_title ?? '') }}"
                                                placeholder="{{ strtoupper($setting->nama_web ?? 'ireng17') }}" maxlength="120">
                                            <label class="form-text text-muted">Popup Background :</label>
                                            <input class="form-control" type="color" value="{{ $setting->popup_bg ?: '#111111' }}"
                                                name="popup_bg">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-text text-muted">Popup Text :</label>
                                            <textarea id="editor" name="msg_popup">{{ $setting->msg_popup }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-text text-muted">CTA Text :</label>
                                            <input class="form-control" type="text" name="popup_cta_text"
                                                value="{{ old('popup_cta_text', $setting->popup_cta_text ?? '') }}"
                                                placeholder="Daftar Sekarang" maxlength="80">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-text text-muted">CTA URL :</label>
                                            <input class="form-control" type="text" name="popup_cta_url"
                                                value="{{ old('popup_cta_url', $setting->popup_cta_url ?? '') }}"
                                                placeholder="/register">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-three-payment" role="tabpanel"
                            aria-labelledby="custom-tabs-three-payment-tab">
                            <form action="{{ route('update.gateway') }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Merchant Number :</label>
                                        <input class="form-control" name="merchantCode"
                                            value="{{ old('merchantCode', $topPayment['merchant_code'] ?? '') }}" type="text" placeholder="isi merchant code" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Status QRIS :</label>
                                        <select class="form-control" name="statusGateway" required>
                                            <option value="1" {{ (int) $setting->qris_status === 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ (int) $setting->qris_status !== 1 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Create Payment URL :</label>
                                        <input class="form-control" name="apiUrl"
                                            value="{{ old('apiUrl', $topPayment['api_url'] ?? 'https://global-id-openapi.toppayment.com/id/pay/prePay') }}" type="url" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Query Status URL :</label>
                                        <input class="form-control" name="queryUrl"
                                            value="{{ old('queryUrl', $topPayment['query_url'] ?? 'https://global-id-openapi.toppayment.com/id/pay/query') }}" type="url" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-text text-muted">Notify / Callback URL :</label>
                                        <input class="form-control" name="notifyUrl"
                                            value="{{ old('notifyUrl', $topPayment['notify_url'] ?? route('jayapay.callback')) }}" type="url" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Private Key Path :</label>
                                        <input class="form-control" name="privateKeyPath"
                                            value="{{ old('privateKeyPath', $topPayment['private_key_path'] ?? 'storage/app/toppayment_private.pem') }}" type="text" required>
                                        <small class="form-text text-muted">Fingerprint: {{ $topPayment['private_key_fingerprint'] ?? 'belum terbaca' }}</small>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Platform Public Key Path :</label>
                                        <input class="form-control" name="publicKeyPath"
                                            value="{{ old('publicKeyPath', $topPayment['public_key_path'] ?? 'storage/app/toppayment_public.pem') }}" type="text" required>
                                        <small class="form-text text-muted">Fingerprint: {{ $topPayment['public_key_fingerprint'] ?? 'belum terbaca' }}</small>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Merchant Private Key :</label>
                                        <textarea class="form-control" name="merchantPrivateKey" rows="7" placeholder="Kosongkan jika tidak ingin mengganti private key."></textarea>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Platform Public Key :</label>
                                        <textarea class="form-control" name="platformPublicKey" rows="7" placeholder="Paste public key platform TopPayment untuk verifikasi callback."></textarea>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-three-deposit-withdraw" role="tabpanel"
                            aria-labelledby="custom-tabs-three-deposit-withdraw-tab">
                            <form action="{{ route('update.depowd') }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="alert alert-info mb-0">
                                            <strong>Setting aktif sekarang:</strong>
                                            Minimal Deposit Rp {{ number_format((int) $setting->minimal_depo, 0, ',', '.') }},
                                            Minimal Withdraw Rp {{ number_format((int) $setting->minimal_wd, 0, ',', '.') }},
                                            Maksimal Withdraw Rp {{ number_format((int) $setting->maksimal_wd, 0, ',', '.') }},
                                            Delay pending deposit {{ (int) ($setting->deposit_delay ?? 24) }} jam.
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Minimal Deposit :</label>
                                        <input class="form-control" name="minim_depo"
                                            value="{{ old('minim_depo', $setting->minimal_depo) }}" type="number" min="1000" step="1000" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Minimal Withdraw :</label>
                                        <input class="form-control" name="minim_wd" value="{{ old('minim_wd', $setting->minimal_wd) }}"
                                            type="number" min="1000" step="1000" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Maksimal Withdraw :</label>
                                        <input class="form-control" name="maks_wd" value="{{ old('maks_wd', $setting->maksimal_wd) }}"
                                            type="number" min="1000" step="1000" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-text text-muted">Delay Pending Deposit (Jam) :</label>
                                        <input class="form-control" name="deposit_delay" value="{{ old('deposit_delay', $setting->deposit_delay ?? 24) }}"
                                            type="number" min="1" max="168" step="1" required>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-three-api" role="tabpanel"
                            aria-labelledby="custom-tabs-three-api-tab">
                            <div class="row">
                                <div class="row">
                                    <div class="col-5 col-sm-3">
                                        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                            aria-orientation="vertical">
                                            <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill"
                                                href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home"
                                                aria-selected="true">Softgaming</a>
                                            <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill"
                                                href="#vert-tabs-profile" role="tab"
                                                aria-controls="vert-tabs-profile" aria-selected="false">Nexus</a>
                                            <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill"
                                                href="#vert-tabs-messages" role="tab"
                                                aria-controls="vert-tabs-messages" aria-selected="false">World Slot
                                                Game</a>
                                            <a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill"
                                                href="#vert-tabs-settings" role="tab"
                                                aria-controls="vert-tabs-settings" aria-selected="false">N-Gaming</a>
                                        </div>
                                    </div>
                                    <div class="col-7 col-sm-9">
                                        <div class="tab-content" id="vert-tabs-tabContent">
                                            <div class="tab-pane text-left fade active show" id="vert-tabs-home"
                                                role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                                                <form action="{{ route('api.sg') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @method('PUT')
                                                    @csrf
                                                    <label for="">Softgaming API</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="form-text text-muted" for="url">Agent Code
                                                                :</label>
                                                            <input class="form-control" name="sgAgentCode"
                                                                value="{{ $api->sg_agent_code }}" type="text">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-text text-muted" for="url">Signature
                                                                :</label>
                                                            <input class="form-control" name="sgSignature"
                                                                value="{{ $api->sg_sign }}" type="text">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-text text-muted" for="url">Endpoint
                                                                :</label>
                                                            <input class="form-control" name="sgEndpoint"
                                                                value="{{ $api->sg_endpoint }}" type="text">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-text text-muted"
                                                                for="url">Status:</label>
                                                            <select class="form-control" name="sgStatus" id="">
                                                                <option value="1"
                                                                    {{ $api->sg_status == 1 ? 'selected' : '' }}>Active
                                                                </option>
                                                                <option value="0"
                                                                    {{ $api->sg_status == 0 ? 'selected' : '' }}>Inactive
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel"
                                                aria-labelledby="vert-tabs-profile-tab">
                                                <form action="{{ route('api.nx') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @method('PUT')
                                                    @csrf
                                                    <label for="">Nexus API</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="form-text text-muted" for="url">Agent Code
                                                                :</label>
                                                            <input class="form-control" name="nxAgentCode"
                                                                value="{{ $api->nx_agent_code }}" type="text">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-text text-muted" for="url">Token
                                                                :</label>
                                                            <input class="form-control" name="nxToken"
                                                                value="{{ $api->nx_token }}" type="text">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-text text-muted" for="url">Agent Secret
                                                                :</label>
                                                            <input class="form-control" name="nxSecret"
                                                                value="{{ $api->nx_secret ?? '' }}" type="text">
                                                            <small class="form-text text-muted">
                                                                Dibutuhkan hanya untuk Seamless Site Endpoint
                                                                <code>/gold_api</code>.
                                                            </small>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-text text-muted" for="url">Endpoint
                                                                :</label>
                                                            <input class="form-control" name="nxEndpoint"
                                                                value="{{ $api->nx_endpoint }}" type="text">
                                                            <small class="form-text text-muted">
                                                                Ambil dari GGR profile: https://{SERVER}/app/profile bagian API Endpoint.
                                                            </small>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-text text-muted"
                                                                for="url">Status:</label>
                                                            <select class="form-control" name="nxStatus" id="">
                                                                <option value="1"
                                                                    {{ $api->nx_status == 1 ? 'selected' : '' }}>Active
                                                                </option>
                                                                <option value="0"
                                                                    {{ $api->nx_status == 0 ? 'selected' : '' }}>Inactive
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel"
                                                aria-labelledby="vert-tabs-messages-tab">
                                                <form action="{{ route('api.wsg') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @method('PUT')
                                                    @csrf
                                                    <label for="">Word Slot API</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="form-text text-muted" for="url">Agent Code
                                                                :</label>
                                                            <input class="form-control" name="wsgAgentCode"
                                                                value="{{ $api->wsg_agent_code }}" type="text">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-text text-muted" for="url">Token
                                                                :</label>
                                                            <input class="form-control" name="wsgToken"
                                                                value="{{ $api->wsg_token }}" type="text">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-text text-muted" for="url">Endpoint
                                                                :</label>
                                                            <input class="form-control" name="wsgEndpoint"
                                                                value="{{ $api->wsg_endpoint }}" type="text">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-text text-muted"
                                                                for="url">Status:</label>
                                                            <select class="form-control" name="wsgStatus" id="">
                                                                <option value="1"
                                                                    {{ $api->wsg_status == 1 ? 'selected' : '' }}>Active
                                                                </option>
                                                                <option value="0"
                                                                    {{ $api->wsg_status == 0 ? 'selected' : '' }}>Inactive
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-settings" role="tabpanel"
                                                aria-labelledby="vert-tabs-settings-tab">
                                                <form action="{{ route('api.ng') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @method('PUT')
                                                    @csrf
                                                    <label for="">N-Gaming API</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="form-text text-muted" for="url">Agent Code
                                                                :</label>
                                                            <input class="form-control" name="ngAgentCode"
                                                                value="{{ $api->ng_agent_code }}" type="text">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-text text-muted" for="url">Signature
                                                                :</label>
                                                            <input class="form-control" name="ngSignature"
                                                                value="{{ $api->ng_signature }}" type="text">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-text text-muted" for="url">Endpoint
                                                                :</label>
                                                            <input class="form-control" name="ngEndpoint"
                                                                value="{{ $api->ng_endpoint }}" type="text">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-text text-muted"
                                                                for="url">Status:</label>
                                                            <select class="form-control" name="ngStatus" id="">
                                                                <option value="1"
                                                                    {{ $api->ng_status == 1 ? 'selected' : '' }}>Active
                                                                </option>
                                                                <option value="0"
                                                                    {{ $api->ng_status == 0 ? 'selected' : '' }}>Inactive
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <br>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
