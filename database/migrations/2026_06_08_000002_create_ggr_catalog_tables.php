<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('ggr_providers')) {
            Schema::create('ggr_providers', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('name');
                $table->string('type', 32)->index();
                $table->boolean('is_open')->default(true)->index();
                $table->timestamp('synced_at')->nullable()->index();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('ggr_games')) {
            Schema::create('ggr_games', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ggr_provider_id')->nullable()->constrained('ggr_providers')->nullOnDelete();
                $table->string('provider_code')->index();
                $table->string('game_code')->default('');
                $table->string('game_name')->index();
                $table->string('type', 32)->default('slot')->index();
                $table->text('banner')->nullable();
                $table->boolean('is_open')->default(true)->index();
                $table->timestamp('synced_at')->nullable()->index();
                $table->timestamps();

                $table->unique(['provider_code', 'game_code']);
                $table->index(['provider_code', 'is_open']);
                $table->index(['type', 'is_open']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ggr_games');
        Schema::dropIfExists('ggr_providers');
    }
};
