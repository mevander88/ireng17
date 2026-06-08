<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->createHistoryTable();
        $this->repairBanksTable();
        $this->createLegacyGameTables();
        $this->addRuntimeIndexes();
    }

    private function createHistoryTable(): void
    {
        if (Schema::hasTable('history')) {
            return;
        }

        Schema::create('history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('trans_id', 300)->nullable();
            $table->bigInteger('jumlah')->default(0);
            $table->unsignedTinyInteger('type')->nullable()->comment('1 Deposit, 2 Withdraw');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'type'], 'history_user_id_type_index');
            $table->index('trans_id', 'history_trans_id_index');
        });
    }

    private function repairBanksTable(): void
    {
        if (!Schema::hasTable('banks')) {
            return;
        }

        Schema::table('banks', function (Blueprint $table) {
            if (!Schema::hasColumn('banks', 'logo')) {
                $table->string('logo')->nullable()->after('image_qr');
            }

            if (!Schema::hasColumn('banks', 'type')) {
                $table->integer('type')->default(1)->after('no_rek')->comment('1 = Bank, 2 = E-Wallet');
            }

            if (!Schema::hasColumn('banks', 'status')) {
                $table->integer('status')->nullable()->after('logo');
            }
        });
    }

    private function createLegacyGameTables(): void
    {
        if (!Schema::hasTable('game_list')) {
            Schema::create('game_list', function (Blueprint $table) {
                $table->id();
                $table->string('provider')->nullable();
                $table->string('image')->nullable();
                $table->boolean('image_is_url')->default(false);
                $table->string('game_id')->nullable();
                $table->string('game_id_long')->nullable();
                $table->string('game_name')->nullable();
                $table->integer('game_type_id')->nullable();
                $table->boolean('game_demo')->default(false);
                $table->string('category')->nullable();
                $table->string('technology')->nullable();
                $table->integer('technology_id')->nullable();
                $table->string('platform')->nullable();
                $table->string('aspect_ratio')->nullable();
                $table->text('jurisdictions')->nullable();
                $table->boolean('frb_available')->default(false);
                $table->string('data_type')->nullable();
                $table->text('features')->nullable();
                $table->unsignedTinyInteger('status')->default(1);
                $table->unsignedTinyInteger('game_locked')->default(0);
                $table->timestamps();

                $table->index(['provider', 'data_type', 'status'], 'game_list_provider_type_status_index');
            });
        }

        if (!Schema::hasTable('game_users')) {
            Schema::create('game_users', function (Blueprint $table) {
                $table->id();
                $table->string('provider')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('ext_id')->nullable();
                $table->unsignedTinyInteger('status')->default(1);
                $table->timestamps();

                $table->index(['provider', 'user_id', 'status'], 'game_users_provider_user_status_index');
            });
        }

        if (!Schema::hasTable('game_lists')) {
            Schema::create('game_lists', function (Blueprint $table) {
                $table->id();
                $table->string('provider')->nullable();
                $table->string('game_name')->nullable();
                $table->string('game_code')->nullable();
                $table->unsignedTinyInteger('status')->default(1);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('w_gamelists')) {
            Schema::create('w_gamelists', function (Blueprint $table) {
                $table->id();
                $table->string('provider')->nullable();
                $table->string('game_name')->nullable();
                $table->string('game_code')->nullable();
                $table->integer('status')->nullable();
                $table->integer('free_rounds_status')->nullable();
                $table->integer('desktop')->nullable();
                $table->integer('mobile')->nullable();
                $table->string('images')->nullable();
                $table->timestamps();
            });
        }
    }

    private function addRuntimeIndexes(): void
    {
        if (!in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        $this->addIndexIfMissing('banks', 'banks_type_status_index', 'ALTER TABLE `banks` ADD INDEX `banks_type_status_index` (`type`, `status`)');
        $this->addIndexIfMissing('transaksi', 'transaksi_ref_index', 'ALTER TABLE `transaksi` ADD INDEX `transaksi_ref_index` (`ref`)');
        $this->addIndexIfMissing('transaksi', 'transaksi_trans_id_index', 'ALTER TABLE `transaksi` ADD INDEX `transaksi_trans_id_index` (`trans_id`)');
        $this->addIndexIfMissing('transaksi', 'transaksi_type_status_index', 'ALTER TABLE `transaksi` ADD INDEX `transaksi_type_status_index` (`type`, `status`)');
        $this->addIndexIfMissing('fiver_games', 'fiver_games_provider_category_status_index', 'ALTER TABLE `fiver_games` ADD INDEX `fiver_games_provider_category_status_index` (`game_provider`, `game_category`, `status`)');
        $this->addIndexIfMissing('games', 'games_provider_category_index', 'ALTER TABLE `games` ADD INDEX `games_provider_category_index` (`game_provider`, `game_category`)');
    }

    private function addIndexIfMissing(string $table, string $index, string $sql): void
    {
        if (!Schema::hasTable($table) || $this->indexExists($table, $index)) {
            return;
        }

        DB::statement($sql);
    }

    private function indexExists(string $table, string $index): bool
    {
        $database = DB::getDatabaseName();
        $rows = DB::select(
            'select 1 from information_schema.statistics where table_schema = ? and table_name = ? and index_name = ? limit 1',
            [$database, $table, $index]
        );

        return !empty($rows);
    }
};
