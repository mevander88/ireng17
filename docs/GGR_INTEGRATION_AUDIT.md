# GGR Integration Audit

Tanggal: 2026-06-12

## Sumber Resmi

- https://ggr.gitbook.io/docs/integration/game-api.md
- https://ggr.gitbook.io/docs/integration/game-api/provider-list.md
- https://ggr.gitbook.io/docs/integration/game-api/game-list.md
- https://ggr.gitbook.io/docs/integration/game-api/game-launch.md
- https://ggr.gitbook.io/docs/integration/game-api/agent-and-user-info.md
- https://ggr.gitbook.io/docs/integration/game-api/game-history.md
- https://ggr.gitbook.io/docs/integration/transfer-api/deposit-withdraw-user-balance.md
- https://ggr.gitbook.io/docs/integration/transfer-api/transfer-status.md
- https://ggr.gitbook.io/docs/integration/seamless-api.md
- https://ggr.gitbook.io/docs/integration/seamless-api/user-balance-site-endpoint.md
- https://ggr.gitbook.io/docs/integration/seamless-api/transaction-site-endpoint.md
- https://ggr.gitbook.io/docs/integration/call-api.md
- https://ggr.gitbook.io/docs/integration/rate-limit.md

## Endpoint Aktif

`api.nexusggr.com` sudah diuji dan mengembalikan `provider_list` sukses.

Konfigurasi aktif dibaca dari table `api`:

- `nx_endpoint`
- `nx_agent_code`
- `nx_token`
- `nx_secret` untuk Seamless callback `/gold_api`

## Integrasi Sesuai Docs

- Game API: provider list, game list, game launch, money info, game history.
- Transfer API: user deposit, user withdraw, reset balance, transfer status wrapper.
- CALL API: current playing users, call list, call apply, call cancel, call history, control single-user RTP, control multi-user RTP wrapper.
- Seamless API: `/gold_api` tersedia untuk `user_balance` dan `transaction`.

## Catatan Seamless

Docs Seamless membutuhkan `agent_secret`. Nilai itu belum diberikan di chat ini. Endpoint `/gold_api` akan menolak request sampai `nx_secret` diisi lewat backoffice Setting API.

Schema user lokal tidak memiliki field `user_token`, jadi validasi callback memakai data yang tersedia dan terdokumentasi kuat di sistem ini: `agent_code`, `agent_secret`, dan `user_code`. Transaksi tetap idempotent berdasarkan `txn_id`.

## Arsitektur Ringan untuk Mobile

- Halaman user tidak memanggil provider list/game list langsung ke GGR.
- Provider dan game disinkronkan ke table lokal `ggr_providers` dan `ggr_games`.
- Gambar game lewat cache lokal/signature route untuk mengurangi request remote berulang.
- Banner homepage dikelola dari table `banner`; fallback statis hanya dipakai jika tidak ada banner aktif.
- AMP index `/amp` memakai data lokal, CSS inline kecil, `amp-img`, tanpa JavaScript aplikasi.
- Rate limit docs dipatuhi untuk sync katalog: provider list dicache singkat, game list diproses bertahap dengan jeda antar provider.
