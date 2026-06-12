<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('genral_settings')) {
            return;
        }

        Schema::table('genral_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('genral_settings', 'popup_enabled')) {
                $table->boolean('popup_enabled')->default(true)->after('popup');
            }

            if (!Schema::hasColumn('genral_settings', 'popup_title')) {
                $table->string('popup_title')->nullable()->after('popup_enabled');
            }

            if (!Schema::hasColumn('genral_settings', 'popup_cta_text')) {
                $table->string('popup_cta_text')->nullable()->after('msg_popup');
            }

            if (!Schema::hasColumn('genral_settings', 'popup_cta_url')) {
                $table->string('popup_cta_url')->nullable()->after('popup_cta_text');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('genral_settings')) {
            return;
        }

        Schema::table('genral_settings', function (Blueprint $table) {
            foreach (['popup_cta_url', 'popup_cta_text', 'popup_title', 'popup_enabled'] as $column) {
                if (Schema::hasColumn('genral_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
