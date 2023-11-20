<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => '$2y$10$7eC0TFvcLkqdVFtxl0S7Pe0p8a0DhxRjSEurd9z4vFyvXSqChOYFO', // password
            'no_telp' => '087727374757',
        ]);
    }
}
