<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserWalletSeeder extends Seeder
{
    private int $chunkSize = 500;

    public function run(): void
    {
        $this->command->info('Seeding user_wallet...');

        $total = DB::connection('eni_old')->table('user_wallet')->count();
        $bar   = $this->command->getOutput()->createProgressBar($total);
        $bar->start();

        DB::connection('eni_old')
            ->table('user_wallet')
            ->orderBy('user_wallet_id')
            ->chunk($this->chunkSize, function ($rows) use ($bar) {
                DB::table('user_wallet')->insert(
                    $rows->map(function ($r) {
                        $row = (array) $r;
                        $row['id'] = $row['user_wallet_id'];
                        unset($row['user_wallet_id']);
                        return $row;
                    })->toArray()
                );
                $bar->advance($rows->count());
            });

        $bar->finish();
        $this->command->newLine();
        $this->command->info("user_wallet done. ($total rows)");
    }
}
