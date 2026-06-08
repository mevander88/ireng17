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
    <div class="mt-3">
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
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-text text-muted">Nama Website
                                                :</label>
                                            <input name="nama_web" type="text" class="form-control"
                                                placeholder="Nama Website" value="{{ $setting->nama_web }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-text text-muted">No TLP:</label>
                                            <input name="telp" type="number" class="form-control"
                                                placeholder="Nomor Telepon format +62" value="{{ $setting->telp }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-text text-muted">SEO Meta Keyword
                                                :</label>
                                            <input name="metaKeyword" type="text" class="form-control" placeholder=""
                                                value="{{ $setting->seo_meta_keywords }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-text text-muted">SEO Description
                                                :</label>
                                            <input name="metaDescription" type="text" class="form-control"
                                                placeholder="" value="{{ $setting->seo_description }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-text text-muted">SEO Social Meta
                                                Description :</label>
                                            <input name="metaSocial" type="text" class="form-control" placeholder=""
                                                value="{{ $setting->seo_social_description }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-text text-muted" for="form-text text-muted">Status
                                                        Website :
                                                        @if ($setting->maintenance_mode == 0)
                                                            <strong style="color: chartreuse"> Online</strong>
                                                        @else
                                                            <strong style="color: rgb(255, 0, 0)"> Maintenance</strong>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>

                                            <select class="form-control" name="maintenance_mode" id="">
                                                <option value="">
                                                    @if ($setting->maintenance_mode == 0)
                                                <option value="1">Maintenance On</option>
                                            @else
                                                <option value="0">Normal</option>
                                                @endif
                                                </option>
                                            </select>
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
                                    <div class="col-6">
                                        <label class="form-text text-muted">Logo Website :</label>
                                        <input name="logo" type="file" class="form-control uploads"
                                            accept="image/png, image/jpeg, image/gif, video/mp4">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-text text-muted">Running Text :</label>
                                        <input name="running_text" type="text" class="form-control"
                                            value="{{ $setting->running_text }}" placeholder="Running Text">
                                    </div>
                                    <div class="col-6">
                                        <label for="exampleInputEmail1" class="form-text text-muted">Template
                                            :</label>
                                        <select name="template" class="form-control">
                                            <option value="main" <?= $setting->template == 'main' ? 'selected' : '' ?>>
                                                Onix/UG
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="Theme" class="form-text text-muted">Theme :</label>
                                            <select name="theme" class="form-control">
                                                <option value="{{ $setting->themes }}">{{ $setting->themes }}</option>
                                                <option value="theme-1">
                                                    Onix Theme
                                                </option>
                                                <option value="theme-2">
                                                    Onix Theme 2
                                                </option>
                                                <option value="theme-3">
                                                    Onix Theme 3
                                                </option>
                                                <option value="theme-4">
                                                    Onix Theme 4
                                                </option>
                                                <option value="theme-5">
                                                    Onix Theme 5
                                                </option>
                                                <option value="theme-6">
                                                    Onix Theme 6
                                                </option>
                                                <option value="theme-7">
                                                    Onix Theme 7
                                                </option>
                                                <option value="theme-8">
                                                    Onix Theme 8
                                                </option>
                                                <option value="theme-9">
                                                    Onix Theme 9
                                                </option>
                                                <option value="theme-10">
                                                    Onix Theme 10
                                                </option>
                                                <option value="theme-11">
                                                    Onix Theme 11
                                                </option>
                                                <option value="theme-12">
                                                    Onix Theme 12
                                                </option>
                                                <option value="theme-13">
                                                    Onix Theme 13
                                                </option>
                                                <option value="theme-14">
                                                    Onix Theme 14
                                                </option>
                                                <option value="theme-15">
                                                    Onix Theme 15
                                                </option>
                                                <option value="theme-16">
                                                    Onix Theme 16
                                                </option>
                                                <option value="theme-17">
                                                    Onix Theme 17
                                                </option>
                                                <option value="theme-18">
                                                    Onix Theme 18
                                                </option>
                                                <option value="theme-19">
                                                    Onix Theme 19
                                                </option>
                                                <option value="theme-20">
                                                    Onix Theme 20
                                                </option>
                                                <option value="theme-21">
                                                    Onix Theme 21
                                                </option>
                                                <option value="theme-22">
                                                    Onix Theme 22
                                                </option>
                                                <option value="theme-23">
                                                    Onix Theme 23
                                                </option>
                                                <option value="theme-24">
                                                    Onix Theme 24
                                                </option>
                                                <option value="theme-25">
                                                    Onix Theme 25
                                                </option>
                                                <option value="theme-26">
                                                    Onix Theme 26
                                                </option>
                                                <option value="theme-27">
                                                    Onix Theme 27
                                                </option>
                                                <option value="theme-28">
                                                    Onix Theme 28
                                                </option>
                                                <option value="theme-29">
                                                    Onix Theme 29
                                                </option>
                                                <option value="theme-30">
                                                    Onix Theme 30
                                                </option>
                                            </select>
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
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-text text-muted">Pop Up Banner :</label>
                                            <input name="popup" type="file" class="form-control uploads"
                                                accept="image/png, image/jpeg, image/gif, video/mp4">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-text text-muted">PopUp Background
                                                :</label>
                                            <input class="form-control" type="color" value="{{ $setting->popup_bg }}"
                                                name="popup_bg">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-text text-muted">Popup Text
                                                :</label>
                                            <textarea id="editor" name="msg_popup">
                                            {{ $setting->msg_popup }}
                                        </textarea>
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
                                    <div class="col-6">
                                        <label class="form-text text-muted" for="url">URL Agregator :</label>
                                        <input class="form-control" name="urlAgregator"
                                            value="{{ $setting->url_gateway }}" type="text">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-text text-muted" for="url">API Key :</label>
                                        <input class="form-control" name="apiKey"
                                            value="{{ $setting->apikey_gateway }}" type="text">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-text text-muted" for="url">Callback Url :</label>
                                        <input class="form-control" name="callback" value="{{ $setting->callback_url }}"
                                            type="text">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-text text-muted" for="url">Status :</label>
                                        <select class="form-control" name="statusGateway" id="">
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
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
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-text text-muted" for="url">Minimalm Deposit :</label>
                                        <input class="form-control" name="minim_depo"
                                            value="{{ $setting->minimal_depo }}" type="number">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-text text-muted" for="url">Minimal Withdraw :</label>
                                        <input class="form-control" name="minim_wd" value="{{ $setting->minimal_wd }}"
                                            type="number">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-text text-muted" for="url">Maksimal Withdraw :</label>
                                        <input class="form-control" name="maks_wd" value="{{ $setting->maksimal_wd }}"
                                            type="number">
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
                                                            <label class="form-text text-muted" for="url">Endpoint
                                                                :</label>
                                                            <input class="form-control" name="nxEndpoint"
                                                                value="{{ $api->nx_endpoint }}" type="text">
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
