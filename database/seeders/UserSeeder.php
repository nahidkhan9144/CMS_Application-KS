<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'author',
                'password' => Hash::make('author123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'nahid',
                'password' => Hash::make('nahid123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
