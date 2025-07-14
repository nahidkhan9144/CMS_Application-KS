<?php


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
                'username' => 'admin',
                'password' => Hash::make('admin123'), // always hash passwords
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'username' => 'author',
                'password' => Hash::make('author123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}

?>