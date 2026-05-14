<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserWalletHistorySeeder extends Seeder
{
    private int $chunkSize = 500;

    public function run(): void
    {
        $this->command->info('Seeding user_wallet_history...');

        $total = DB::connection('eni_old')->table('user_wallet_history')->count();
        $bar   = $this->command->getOutput()->createProgressBar($total);
        $bar->start();

        DB::connection('eni_old')
            ->table('user_wallet_history')
            ->orderBy('id')
            ->chunk($this->chunkSize, function ($rows) use ($bar) {
                DB::table('user_wallet_history')->insert($rows->map(fn ($r) => (array) $r)->toArray());
                $bar->advance($rows->count());
            });

        $bar->finish();
        $this->command->newLine();
        $this->command->info("user_wallet_history done. ($total rows)");
    }
}
