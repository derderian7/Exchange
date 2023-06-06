<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    User::truncate();




        DB::table('users')->insert([
            'name' => 'leen',
            'email' => 'leen@gmail.com',
            'password' => Hash::make('rleen123'),
        ]);

        DB::table('users')->insert([
            'name' => 'tareem',
            'email' => 'tareem@gmail.com',
            'password' => Hash::make('tareem123'),
        ]);

        DB::table('users')->insert([
            'name' => 'mona',
            'email' => 'mona@gmail.com',
            'password' => Hash::make('mona123'),
        ]);

        DB::table('users')->insert([
            'name' => 'reem',
            'email' => 'reem@gmail.com',
            'password' => Hash::make('reem123'),
        ]);

        DB::table('users')->insert([
            'name' => 'lama',
            'email' => 'lama@gmail.com',
            'password' => Hash::make('lama123'),
        ]);

    }
}
