<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if user already exists
        $exists = DB::table('users')->where('email', 'admin@wellmeadows.com')->exists();

        if (!$exists) {
            DB::table('users')->insert([
                'name' => 'Admin',
                'staff_no' => 'S055', // Laurence (Consultant)
                'email' => 'admin@wellmeadows.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->call([
            WellMeadowsSeeder::class,
        ]);
    }
}
