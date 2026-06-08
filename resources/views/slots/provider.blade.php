@extends('layouts.main')

@php
    $providerItems = collect($providers ?? []);
@endphp

@desktop
    @section('desktop')
        <div class="container provider-page">
            <div class="provider-toolbar">
                <div>
                    <span class="provider-kicker">Slot providers</span>
                    <h1>Daftar Provider Slot</h1>
                </div>
                <div class="provider-count">{{ $providerItems->count() }} Provider</div>
            </div>

            <div class="provider-grid">
                @forelse ($providerItems as $provider)
                    <a class="provider-card" href="{{ $provider->url }}" data-provider="{{ $provider->api_provider }}">
                        <div class="provider-media">
                            <img src="{{ $provider->image }}" alt="{{ $provider->name }}" loading="lazy">
                        </div>
                        <div class="provider-body">
                            <span>{{ $provider->api_provider }}</span>
                            <strong>{{ $provider->name }}</strong>
                            <small>{{ $provider->count }} game tersedia</small>
                        </div>
                    </a>
                @empty
                    <div class="game-empty-state">Provider belum tersedia.</div>
                @endforelse
            </div>
        </div>
    @endsection
@elsedesktop
    @section('content')
        <div class="container provider-page">
            <div class="provider-toolbar">
                <div>
                    <span class="provider-kicker">Slot providers</span>
                    <h1>Daftar Provider Slot</h1>
                </div>
                <div class="provider-count">{{ $providerItems->count() }}</div>
            </div>

            <div class="provider-grid">
                @forelse ($providerItems as $provider)
                    <a class="provider-card" href="{{ $provider->url }}" data-provider="{{ $provider->api_provider }}">
                        <div class="provider-media">
                            <img src="{{ $provider->image }}" alt="{{ $provider->name }}" loading="lazy">
                        </div>
                        <div class="provider-body">
                            <span>{{ $provider->api_provider }}</span>
                            <strong>{{ $provider->name }}</strong>
                            <small>{{ $provider->count }} game</small>
                        </div>
                    </a>
                @empty
                    <div class="game-empty-state">Provider belum tersedia.</div>
                @endforelse
            </div>
        </div>
    @endsection
@enddesktop
