<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'M. Dzikri Sagara',
            'email' => 'dzikri@ukri.ac.id',
            'nim' => '20241320004',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => true,
        ]);

        User::create([
            'nama' => 'Jilan Jalilah',
            'email' => 'jilan@ukri.ac.id',
            'nim' => '20241320039',
            'password' => Hash::make('password'),
            'role' => 'user',
            'status' => true,
        ]);

        User::create([
            'nama' => 'Nosa Putra',
            'email' => 'nosa@ukri.ac.id',
            'nim' => '20241320025',
            'password' => Hash::make('password'),
            'role' => 'user',
            'status' => true,
        ]);

        User::create([
            'nama' => 'Ahmad Sahrul P',
            'email' => 'sahrul@ukri.ac.id',
            'nim' => '20241320031',
            'password' => Hash::make('password'),
            'role' => 'user',
            'status' => true,
        ]);

        User::create([
            'nama' => 'Eka Pebryanto',
            'email' => 'eka@ukri.ac.id',
            'nim' => '20241320014',
            'password' => Hash::make('password'),
            'role' => 'user',
            'status' => true,
        ]);
    }
}

