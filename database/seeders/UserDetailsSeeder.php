<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDetailsSeeder extends Seeder
{
    private int $chunkSize = 500;

    public function run(): void
    {
        $this->command->info('Seeding user_details...');

        $total = DB::connection('eni_old')->table('user_details')->count();
        $bar   = $this->command->getOutput()->createProgressBar($total);
        $bar->start();

        DB::connection('eni_old')
            ->table('user_details')
            ->orderBy('user_details_id')
            ->chunk($this->chunkSize, function ($rows) use ($bar) {
                DB::table('user_details')->insert(
                    $rows->map(function ($r) {
                        $row = (array) $r;
                        $row['id'] = $row['user_details_id'];
                        unset($row['user_details_id']);
                        return $row;
                    })->toArray()
                );
                $bar->advance($rows->count());
            });

        $bar->finish();
        $this->command->newLine();
        $this->command->info("user_details done. ($total rows)");
    }
}
