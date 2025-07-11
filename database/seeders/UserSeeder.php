<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            "id" => 1,
            "name" => "Bülent ERCAN",
            "email" => "admin@bulentercan.com.tr",
            "password" => Hash::make("password"),
        ]);
    }
}
