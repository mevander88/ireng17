<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('transaksi')) {
            return;
        }

        Schema::table('transaksi', function (Blueprint $table) {
            if (!Schema::hasColumn('transaksi', 'qris_url')) {
                $table->string('qris_url')->nullable()->after('bukti_transfer');
            }

            if (!Schema::hasColumn('transaksi', 'external_id')) {
                $table->string('external_id')->nullable()->after('qris_url');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('transaksi')) {
            return;
        }

        Schema::table('transaksi', function (Blueprint $table) {
            foreach (['external_id', 'qris_url'] as $column) {
                if (Schema::hasColumn('transaksi', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
