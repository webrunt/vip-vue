<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding user_roles...');

        $roles = DB::connection('eni_old')->table('user_roles')->get();

        if ($roles->isEmpty()) {
            // Fallback: insert the 6 known roles if old DB has none
            DB::table('user_roles')->insert([
                ['user_role_id' => 1, 'role_name' => 'Admin',            'status' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['user_role_id' => 2, 'role_name' => 'Member',           'status' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['user_role_id' => 3, 'role_name' => 'Staff',            'status' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['user_role_id' => 4, 'role_name' => 'Affiliate',        'status' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['user_role_id' => 5, 'role_name' => 'Customer Service', 'status' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['user_role_id' => 6, 'role_name' => 'Cashier',          'status' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);
        } else {
            foreach ($roles as $role) {
                DB::table('user_roles')->insert((array) $role);
            }
        }

        $this->command->info('user_roles done.');
    }
}
