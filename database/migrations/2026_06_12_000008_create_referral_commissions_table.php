<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('networks')) {
            Schema::table('networks', function (Blueprint $table) {
                if (!Schema::hasColumn('networks', 'parent_id')) {
                    $table->unsignedBigInteger('parent_id')->nullable()->after('ref_code');
                }

                if (!Schema::hasColumn('networks', 'username')) {
                    $table->string('username', 50)->nullable()->after('user_id');
                }
            });

            if (Schema::hasColumn('networks', 'parnet_id') && Schema::hasColumn('networks', 'parent_id')) {
                DB::table('networks')
                    ->whereNull('parent_id')
                    ->whereNotNull('parnet_id')
                    ->update(['parent_id' => DB::raw('parnet_id')]);
            }

            if (in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
                $indexes = collect(DB::select(
                    'SELECT index_name, non_unique FROM information_schema.statistics WHERE table_schema = ? AND table_name = ? AND index_name IN (?, ?)',
                    [DB::getDatabaseName(), 'networks', 'networks_ref_code_unique', 'networks_ref_code_index']
                ));

                if ($indexes->firstWhere('index_name', 'networks_ref_code_unique')) {
                    DB::statement('ALTER TABLE `networks` DROP INDEX `networks_ref_code_unique`');
                }

                if (!$indexes->firstWhere('index_name', 'networks_ref_code_index')) {
                    DB::statement('ALTER TABLE `networks` ADD INDEX `networks_ref_code_index` (`ref_code`)');
                }
            }
        }

        if (!Schema::hasTable('referral_commissions')) {
            Schema::create('referral_commissions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('transaksi_id')->unique();
                $table->unsignedBigInteger('referred_user_id')->index();
                $table->unsignedBigInteger('referrer_user_id')->index();
                $table->string('referral_code', 50)->nullable()->index();
                $table->unsignedBigInteger('deposit_amount')->default(0);
                $table->unsignedBigInteger('commission_amount')->default(0);
                $table->string('status', 20)->default('pending')->index();
                $table->text('provider_response')->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('referral_commissions');
    }
};
