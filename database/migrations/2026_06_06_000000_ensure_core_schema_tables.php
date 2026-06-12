<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('extplayer', 50)->nullable();
                $table->string('name')->index();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
                $table->string('ip_register', 40)->nullable();
                $table->integer('level')->nullable();
                $table->string('telp')->nullable();
                $table->string('ref_code')->nullable();
                $table->string('ref_link', 100)->nullable();
                $table->string('nama_rek')->nullable();
                $table->string('bank')->nullable();
                $table->string('no_rek')->nullable();
                $table->string('captcha', 11)->nullable();
                $table->integer('game_mode')->nullable();

                $table->index(['name', 'telp', 'email'], 'users_name_telp_email_index');
            });
        }

        if (!Schema::hasTable('api')) {
            Schema::create('api', function (Blueprint $table) {
                $table->integer('id')->primary();
                $table->string('sg_agent_code')->nullable();
                $table->string('sg_sign')->nullable();
                $table->string('sg_endpoint')->nullable();
                $table->string('nx_agent_code')->nullable();
                $table->string('nx_token')->nullable();
                $table->string('nx_secret')->nullable();
                $table->string('nx_endpoint')->nullable();
                $table->string('wsg_agent_code')->nullable();
                $table->string('wsg_token')->nullable();
                $table->string('wsg_endpoint')->nullable();
                $table->string('ng_agent_code')->nullable();
                $table->string('ng_signature')->nullable();
                $table->string('ng_endpoint')->nullable();
                $table->string('sg_status')->nullable();
                $table->string('nx_status')->nullable();
                $table->string('ng_status')->nullable();
                $table->string('wsg_status')->nullable();
                $table->timestamp('updated_at')->nullable();
            });
        }

        if (!Schema::hasTable('genral_settings')) {
            Schema::create('genral_settings', function (Blueprint $table) {
                $table->integer('id')->primary();
                $table->string('nama_web')->nullable();
                $table->string('telp')->nullable();
                $table->string('wa')->nullable();
                $table->string('tele')->nullable();
                $table->text('running_text')->nullable();
                $table->string('logo')->nullable();
                $table->string('popup')->nullable();
                $table->boolean('popup_enabled')->default(true);
                $table->string('popup_title')->nullable();
                $table->string('popup_bg')->nullable();
                $table->string('favicon')->nullable();
                $table->string('template')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->string('live_chat')->nullable();
                $table->string('live_chat_js', 2000)->nullable();
                $table->longText('msg_popup')->nullable();
                $table->string('popup_cta_text')->nullable();
                $table->string('popup_cta_url')->nullable();
                $table->string('themes')->nullable();
                $table->longText('seo_banner')->nullable();
                $table->longText('seo_meta_keywords')->nullable();
                $table->longText('seo_description')->nullable();
                $table->longText('seo_social_title')->nullable();
                $table->longText('seo_social_description')->nullable();
                $table->integer('maintenance_mode')->default(0);
                $table->integer('deposit_delay')->default(24);
                $table->string('url_gateway')->nullable();
                $table->string('apikey_gateway')->nullable();
                $table->string('callback_url')->nullable();
                $table->integer('qris_status')->default(0);
                $table->string('qris_image')->nullable();
                $table->integer('minimal_depo')->nullable();
                $table->integer('maksimal_wd')->nullable();
                $table->integer('minimal_wd')->nullable();
            });
        }

        if (!Schema::hasTable('banner')) {
            Schema::create('banner', function (Blueprint $table) {
                $table->integer('id')->primary();
                $table->text('gambar')->nullable();
                $table->string('status')->nullable();
                $table->string('nama')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        }

        if (!Schema::hasTable('banner_promosi')) {
            Schema::create('banner_promosi', function (Blueprint $table) {
                $table->id();
                $table->string('nama')->nullable();
                $table->text('deskripsi')->nullable();
                $table->string('gambar')->nullable();
                $table->string('status')->nullable();
                $table->timestamps();
                $table->string('kategori')->nullable();
                $table->dateTime('batas_waktu')->nullable();
            });
        }

        if (!Schema::hasTable('bonuses')) {
            Schema::create('bonuses', function (Blueprint $table) {
                $table->id();
                $table->string('judul')->nullable();
                $table->text('keterangan')->nullable();
                $table->integer('nominal')->nullable();
                $table->string('status')->nullable();
                $table->timestamps();
                $table->bigInteger('minimal')->nullable();
            });
        }

        if (!Schema::hasTable('saldo')) {
            Schema::create('saldo', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('user_id')->nullable()->index();
                $table->string('user_name')->nullable();
                $table->bigInteger('saldo')->default(0);
                $table->bigInteger('bonus')->default(0);
                $table->integer('status')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        }

        if (!Schema::hasTable('transaksi')) {
            Schema::create('transaksi', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->string('ref', 50)->nullable()->index();
                $table->string('type')->nullable();
                $table->string('status')->nullable();
                $table->string('trans_id', 300)->nullable()->index();
                $table->unsignedBigInteger('bonus_id')->nullable();
                $table->integer('bonus_persentase')->nullable();
                $table->integer('nominal')->nullable();
                $table->integer('user_id')->nullable()->index();
                $table->string('user_name')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('approved_at')->nullable();
                $table->string('approved_by')->nullable();
                $table->text('bukti_transfer')->nullable();
                $table->integer('bank_id')->nullable();
                $table->string('rek_pengirim')->nullable();
                $table->text('keterangan')->nullable();
                $table->text('alasan')->nullable();
                $table->string('qris_url')->nullable();
                $table->string('external_id')->nullable();
                $table->string('qris_code')->nullable();

                $table->index(['user_id', 'bank_id', 'status'], 'transaksi_user_id_bank_id_status_index');
                $table->index(['type', 'status'], 'transaksi_type_status_index');
            });
        }

        if (!Schema::hasTable('saldo_log')) {
            Schema::create('saldo_log', function (Blueprint $table) {
                $table->id();
                $table->integer('saldo_id')->nullable();
                $table->integer('user_id')->nullable();
                $table->text('type')->nullable();
                $table->integer('saldo_before')->nullable();
                $table->integer('saldo_trans')->nullable();
                $table->integer('saldo_after')->nullable();
                $table->integer('bonus_before')->nullable();
                $table->integer('bonus_trans')->nullable();
                $table->integer('bonus_after')->nullable();
                $table->integer('status')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('failed_jobs')) {
            Schema::create('failed_jobs', function (Blueprint $table) {
                $table->id();
                $table->string('uuid')->unique();
                $table->text('connection');
                $table->text('queue');
                $table->longText('payload');
                $table->longText('exception');
                $table->timestamp('failed_at')->useCurrent();
            });
        }

        if (!Schema::hasTable('password_reset_tokens')) {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        // This migration only fills missing dump-era core tables.
        // Dropping them on rollback would be destructive for existing installs.
    }
};
