<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        $this->addUniqueIfSafe('users', 'users_name_unique', ['name']);
        $this->addUniqueIfSafe('saldo', 'saldo_user_id_unique', ['user_id']);
        $this->addUniqueIfSafe('networks', 'networks_user_id_unique', ['user_id']);
        $this->addUniqueIfSafe('networks', 'networks_ref_code_unique', ['ref_code']);
        $this->addUniqueIfSafe('transaksi', 'transaksi_trans_id_unique', ['trans_id']);
        $this->addUniqueIfSafe('transaksi', 'transaksi_external_id_unique', ['external_id']);
        $this->addIndexIfMissing('transaksi', 'transaksi_user_type_status_created_index', ['user_id', 'type', 'status', 'created_at']);
        $this->addIndexIfMissing('transaksi', 'transaksi_status_approved_at_index', ['status', 'approved_at']);

        $this->addForeignIfSafe('history', 'history_user_id_foreign', 'user_id', 'users', 'id', 'set null');
        $this->addForeignIfSafe('spins', 'spins_user_id_foreign', 'user_id', 'users', 'id', 'cascade');
        $this->addForeignIfSafe('ggr_seamless_transactions', 'ggr_seamless_transactions_user_id_foreign', 'user_id', 'users', 'id', 'set null');

        foreach ([
            'bonus_lama',
            'fiver_games2',
            'game_lists',
            'game_transaction',
            'promosi',
            'slot_game_histories',
            'tb_gamenew',
            'user_logins',
            'password_resets',
        ] as $table) {
            $this->dropIfEmpty($table);
        }
    }

    public function down(): void
    {
        if (!in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        $this->dropForeignIfExists('ggr_seamless_transactions', 'ggr_seamless_transactions_user_id_foreign');
        $this->dropForeignIfExists('spins', 'spins_user_id_foreign');
        $this->dropForeignIfExists('history', 'history_user_id_foreign');

        foreach ([
            ['transaksi', 'transaksi_status_approved_at_index'],
            ['transaksi', 'transaksi_user_type_status_created_index'],
            ['transaksi', 'transaksi_external_id_unique'],
            ['transaksi', 'transaksi_trans_id_unique'],
            ['networks', 'networks_ref_code_unique'],
            ['networks', 'networks_user_id_unique'],
            ['saldo', 'saldo_user_id_unique'],
            ['users', 'users_name_unique'],
        ] as [$table, $index]) {
            $this->dropIndexIfExists($table, $index);
        }
    }

    private function addUniqueIfSafe(string $table, string $index, array $columns): void
    {
        if (!$this->tableHasColumns($table, $columns) || $this->indexExists($table, $index)) {
            return;
        }

        if ($this->hasDuplicateValues($table, $columns)) {
            return;
        }

        DB::statement(sprintf(
            'ALTER TABLE `%s` ADD UNIQUE `%s` (%s)',
            $table,
            $index,
            $this->columnList($columns)
        ));
    }

    private function addIndexIfMissing(string $table, string $index, array $columns): void
    {
        if (!$this->tableHasColumns($table, $columns) || $this->indexExists($table, $index)) {
            return;
        }

        DB::statement(sprintf(
            'ALTER TABLE `%s` ADD INDEX `%s` (%s)',
            $table,
            $index,
            $this->columnList($columns)
        ));
    }

    private function addForeignIfSafe(
        string $table,
        string $foreign,
        string $column,
        string $referenceTable,
        string $referenceColumn,
        string $onDelete
    ): void {
        if (
            !$this->tableHasColumns($table, [$column])
            || !$this->tableHasColumns($referenceTable, [$referenceColumn])
            || $this->foreignExists($table, $foreign)
            || $this->hasOrphans($table, $column, $referenceTable, $referenceColumn)
        ) {
            return;
        }

        $this->addIndexIfMissing($table, $foreign . '_index', [$column]);

        $deleteSql = match ($onDelete) {
            'cascade' => 'ON DELETE CASCADE',
            'set null' => 'ON DELETE SET NULL',
            default => '',
        };

        DB::statement(sprintf(
            'ALTER TABLE `%s` ADD CONSTRAINT `%s` FOREIGN KEY (`%s`) REFERENCES `%s` (`%s`) %s',
            $table,
            $foreign,
            $column,
            $referenceTable,
            $referenceColumn,
            $deleteSql
        ));
    }

    private function dropIfEmpty(string $table): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        if ((int) DB::table($table)->count() > 0) {
            return;
        }

        Schema::drop($table);
    }

    private function tableHasColumns(string $table, array $columns): bool
    {
        if (!Schema::hasTable($table)) {
            return false;
        }

        foreach ($columns as $column) {
            if (!Schema::hasColumn($table, $column)) {
                return false;
            }
        }

        return true;
    }

    private function hasDuplicateValues(string $table, array $columns): bool
    {
        $where = collect($columns)
            ->map(fn (string $column): string => "`{$column}` IS NOT NULL")
            ->implode(' AND ');

        $groupBy = $this->columnList($columns);

        $rows = DB::select(
            "SELECT 1 FROM `{$table}` WHERE {$where} GROUP BY {$groupBy} HAVING COUNT(*) > 1 LIMIT 1"
        );

        return !empty($rows);
    }

    private function hasOrphans(string $table, string $column, string $referenceTable, string $referenceColumn): bool
    {
        $rows = DB::select(
            "SELECT 1 FROM `{$table}` t LEFT JOIN `{$referenceTable}` r ON t.`{$column}` = r.`{$referenceColumn}` WHERE t.`{$column}` IS NOT NULL AND r.`{$referenceColumn}` IS NULL LIMIT 1"
        );

        return !empty($rows);
    }

    private function indexExists(string $table, string $index): bool
    {
        return !empty(DB::select(
            'SELECT 1 FROM information_schema.statistics WHERE table_schema = ? AND table_name = ? AND index_name = ? LIMIT 1',
            [DB::getDatabaseName(), $table, $index]
        ));
    }

    private function foreignExists(string $table, string $foreign): bool
    {
        return !empty(DB::select(
            'SELECT 1 FROM information_schema.table_constraints WHERE table_schema = ? AND table_name = ? AND constraint_name = ? AND constraint_type = ? LIMIT 1',
            [DB::getDatabaseName(), $table, $foreign, 'FOREIGN KEY']
        ));
    }

    private function dropForeignIfExists(string $table, string $foreign): void
    {
        if (Schema::hasTable($table) && $this->foreignExists($table, $foreign)) {
            DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$foreign}`");
        }
    }

    private function dropIndexIfExists(string $table, string $index): void
    {
        if (Schema::hasTable($table) && $this->indexExists($table, $index)) {
            DB::statement("ALTER TABLE `{$table}` DROP INDEX `{$index}`");
        }
    }

    private function columnList(array $columns): string
    {
        return collect($columns)
            ->map(fn (string $column): string => "`{$column}`")
            ->implode(', ');
    }
};
