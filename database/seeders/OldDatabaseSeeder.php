<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OldDatabaseSeeder extends Seeder
{
    /**
     * Chunk size for bulk inserts. 500 is a safe balance between speed and
     * memory usage. Increase to 1000 if your server has plenty of RAM.
     */
    private int $chunkSize = 500;

    public function run(): void
    {
        // Disable foreign key checks so we can insert in any order
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([
            UserRolesSeeder::class,
            UsersSeeder::class,
            UserDetailsSeeder::class,
            UserAffiliatesSeeder::class,
            UserWalletSeeder::class,
            UserWalletHistorySeeder::class,
            UserSmsSettingSeeder::class,
            UserSmsMessageHistorySeeder::class,
            UserSmsLoadHistorySeeder::class,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
