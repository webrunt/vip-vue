<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    private int $chunkSize = 500;

    public function run(): void
    {
        $this->command->info('Seeding users...');

        $columns = [
            'user_id as id', // old PK → standard 'id'
            'username', 'email', 'password', 'security_pin',
            'role_id', 'activation_code', 'forgot_code', 'date_activated',
            'last_login', 'is_blocked', 'is_active', 'is_corpo', 'shop_name',
            'shop_activated', 'num_used', 'unhash_password', 'unhash_security_pin',
            'temp_password', 'last_activity_date', 'last_activity', 'remember_token',
            'otp', 'last_otp', 'otp_step', 'left_build', 'created_at', 'updated_at',
        ];

        $total = DB::connection('eni_old')->table('users')->count();
        $bar   = $this->command->getOutput()->createProgressBar($total);
        $bar->start();

        DB::connection('eni_old')
            ->table('users')
            ->orderBy('user_id')
            ->select($columns)
            ->chunk($this->chunkSize, function ($rows) use ($bar) {
                DB::table('users')->insertOrIgnore(
                    $rows->map(function ($r) {
                        $row = (array) $r;
                        // Normalize email to lowercase to handle case-insensitive duplicates
                        $row['email'] = strtolower($row['email']);
                        return $row;
                    })->toArray()
                );
                $bar->advance($rows->count());
            });

        $bar->finish();
        $this->command->newLine();
        $this->command->info("users done. ($total rows)");
    }
}
