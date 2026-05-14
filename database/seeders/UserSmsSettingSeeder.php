<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSmsSettingSeeder extends Seeder
{
    private int $chunkSize = 500;

    public function run(): void
    {
        $this->command->info('Seeding user_sms_setting...');

        $total = DB::connection('eni_old')->table('user_sms_setting')->count();
        $bar   = $this->command->getOutput()->createProgressBar($total);
        $bar->start();

        DB::connection('eni_old')
            ->table('user_sms_setting')
            ->orderBy('user_sms_setting_id')
            ->chunk($this->chunkSize, function ($rows) use ($bar) {
                DB::table('user_sms_setting')->insert(
                    $rows->map(function ($r) {
                        $row = (array) $r;
                        $row['id'] = $row['user_sms_setting_id'];
                        unset($row['user_sms_setting_id']);
                        return $row;
                    })->toArray()
                );
                $bar->advance($rows->count());
            });

        $bar->finish();
        $this->command->newLine();
        $this->command->info("user_sms_setting done. ($total rows)");
    }
}
