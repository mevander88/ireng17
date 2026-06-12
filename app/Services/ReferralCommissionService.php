<?php

namespace App\Services;

use App\Http\Api\fiver;
use App\Models\Network;
use App\Models\Saldo;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReferralCommissionService
{
    private const RATE = 0.20;

    public function creditForDeposit(Transaksi $deposit): bool
    {
        if ((int) $deposit->type !== 1 || (int) $deposit->status !== 2 || (int) $deposit->nominal <= 0) {
            return false;
        }

        $network = Network::query()
            ->where('user_id', $deposit->user_id)
            ->whereNotNull('parent_id')
            ->first();

        if (!$network || (int) $network->parent_id === (int) $deposit->user_id) {
            return false;
        }

        $referrer = User::find($network->parent_id);
        if (!$referrer) {
            return false;
        }

        $commission = (int) floor((int) $deposit->nominal * self::RATE);
        if ($commission <= 0) {
            return false;
        }

        $record = DB::transaction(function () use ($deposit, $network, $referrer, $commission) {
            $existing = DB::table('referral_commissions')
                ->where('transaksi_id', $deposit->id)
                ->lockForUpdate()
                ->first();

            if ($existing && $existing->status === 'paid') {
                return null;
            }

            if ($existing) {
                DB::table('referral_commissions')
                    ->where('id', $existing->id)
                    ->update([
                        'status' => 'pending',
                        'updated_at' => now(),
                    ]);

                return DB::table('referral_commissions')->where('id', $existing->id)->first();
            }

            $id = DB::table('referral_commissions')->insertGetId([
                'transaksi_id' => $deposit->id,
                'referred_user_id' => $deposit->user_id,
                'referrer_user_id' => $referrer->id,
                'referral_code' => $network->ref_code,
                'deposit_amount' => (int) $deposit->nominal,
                'commission_amount' => $commission,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return DB::table('referral_commissions')->where('id', $id)->first();
        });

        if (!$record) {
            return true;
        }

        try {
            $provider = new fiver();
            $agentSign = 'REF' . $deposit->trans_id;
            $transferStatus = json_decode($provider->transferStatus($referrer->name, $agentSign));

            if ($this->providerSucceeded($transferStatus)) {
                $this->syncReferrerBalance($provider, $referrer, $commission);
                $this->markPaid($record->id, $deposit, $referrer, $commission, $agentSign, $transferStatus);

                return true;
            }

            $providerResponse = json_decode($provider->deposit($referrer->name, $commission, $agentSign));

            if (!$this->providerSucceeded($providerResponse)) {
                DB::table('referral_commissions')->where('id', $record->id)->update([
                    'status' => 'failed',
                    'provider_response' => json_encode($providerResponse, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                    'updated_at' => now(),
                ]);

                Log::warning('Referral commission provider deposit failed', [
                    'transaksi_id' => $deposit->id,
                    'referrer_user_id' => $referrer->id,
                    'response' => (array) $providerResponse,
                ]);

                return false;
            }

            $this->syncReferrerBalance($provider, $referrer, $commission);
            $this->markPaid($record->id, $deposit, $referrer, $commission, $agentSign, $providerResponse);

            return true;
        } catch (\Throwable $e) {
            DB::table('referral_commissions')->where('id', $record->id)->update([
                'status' => 'failed',
                'provider_response' => $e->getMessage(),
                'updated_at' => now(),
            ]);

            Log::error('Referral commission error', [
                'transaksi_id' => $deposit->id,
                'referrer_user_id' => $referrer->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    private function providerSucceeded(mixed $response): bool
    {
        return isset($response->status) && in_array($response->status, [1, '1', 'success', 'SUCCESS'], true);
    }

    private function syncReferrerBalance(fiver $provider, User $referrer, int $commission): void
    {
        $balanceResponse = json_decode($provider->userbalance($referrer->name));
        $newBalance = $balanceResponse->user->balance ?? null;

        if ($newBalance !== null) {
            Saldo::updateOrCreate(
                ['user_id' => $referrer->id],
                ['user_name' => $referrer->name, 'saldo' => $newBalance]
            );
            return;
        }

        $saldo = Saldo::firstOrCreate(
            ['user_id' => $referrer->id],
            ['user_name' => $referrer->name, 'saldo' => 0, 'bonus' => 0]
        );
        $saldo->increment('saldo', $commission);
    }

    private function markPaid(int $recordId, Transaksi $deposit, User $referrer, int $commission, string $agentSign, mixed $response): void
    {
        DB::transaction(function () use ($recordId, $deposit, $referrer, $commission, $agentSign, $response) {
            DB::table('referral_commissions')->where('id', $recordId)->update([
                'status' => 'paid',
                'provider_response' => json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                'paid_at' => now(),
                'updated_at' => now(),
            ]);

            $historyExists = DB::table('history')
                ->where('user_id', $referrer->id)
                ->where('trans_id', $agentSign)
                ->exists();

            if (!$historyExists) {
                DB::table('history')->insert([
                    'user_id' => $referrer->id,
                    'trans_id' => $agentSign,
                    'jumlah' => $commission,
                    'type' => 4,
                    'keterangan' => 'Komisi referral 20% dari deposit ' . ($deposit->user_name ?? $deposit->user_id),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }

    public function summaryForUser(int $userId): array
    {
        return [
            'members' => Network::where('parent_id', $userId)->count(),
            'paid_total' => (int) DB::table('referral_commissions')
                ->where('referrer_user_id', $userId)
                ->where('status', 'paid')
                ->sum('commission_amount'),
            'pending_total' => (int) DB::table('referral_commissions')
                ->where('referrer_user_id', $userId)
                ->where('status', 'pending')
                ->sum('commission_amount'),
            'paid_count' => (int) DB::table('referral_commissions')
                ->where('referrer_user_id', $userId)
                ->where('status', 'paid')
                ->count(),
        ];
    }
}
