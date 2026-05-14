<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAffiliatesSeeder extends Seeder
{
    private int $chunkSize = 500;

    public function run(): void
    {
        $this->command->info('Seeding user_affiliates...');

        $total = DB::connection('eni_old')->table('user_affiliates')->count();
        $bar   = $this->command->getOutput()->createProgressBar($total);
        $bar->start();

        DB::connection('eni_old')
            ->table('user_affiliates')
            ->orderBy('user_affiliate_id')
            ->chunk($this->chunkSize, function ($rows) use ($bar) {
                DB::table('user_affiliates')->insert(
                    $rows->map(function ($r) {
                        $row = (array) $r;
                        $row['id'] = $row['user_affiliate_id'];
                        unset($row['user_affiliate_id']);
                        return $row;
                    })->toArray()
                );
                $bar->advance($rows->count());
            });

        $bar->finish();
        $this->command->newLine();
        $this->command->info("user_affiliates done. ($total rows)");
    }
}
