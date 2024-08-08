<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        // DB::table('students')->truncate();

        // Insert new data
        DB::table('students')->insert([
            [
                'username' => 'john_doe',
                'password' => Hash::make('password123'), // Hash the password
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'jane_doe',
                'password' => Hash::make('password123'), // Hash the password
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '21-020055',
                'password' => Hash::make('romeo'), // Hash the password
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
