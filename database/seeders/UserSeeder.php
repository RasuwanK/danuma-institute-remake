<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->count(10)->create(); 

        User::create([
            'name' => 'rushani',
            'email' => 'rushani@gmail.com',
            'password' => Hash::make('123'), 
        ]);
    }
}
