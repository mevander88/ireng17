<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('api') && !Schema::hasColumn('api', 'nx_secret')) {
            Schema::table('api', function (Blueprint $table) {
                $table->string('nx_secret')->nullable()->after('nx_token');
            });
        }

        if (!Schema::hasTable('ggr_seamless_transactions')) {
            Schema::create('ggr_seamless_transactions', function (Blueprint $table) {
                $table->id();
                $table->string('txn_id')->unique();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('user_code')->index();
                $table->string('game_type', 32)->nullable();
                $table->string('provider_code', 64)->nullable();
                $table->string('game_code', 128)->nullable();
                $table->string('txn_type', 32)->nullable();
                $table->decimal('bet_money', 18, 2)->default(0);
                $table->decimal('win_money', 18, 2)->default(0);
                $table->decimal('balance_before', 18, 2)->default(0);
                $table->decimal('balance_after', 18, 2)->default(0);
                $table->json('payload')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ggr_seamless_transactions');

        if (Schema::hasTable('api') && Schema::hasColumn('api', 'nx_secret')) {
            Schema::table('api', function (Blueprint $table) {
                $table->dropColumn('nx_secret');
            });
        }
    }
};
