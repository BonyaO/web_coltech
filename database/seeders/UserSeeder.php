<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Bless Darah",
            "email" => "user@test.com",
            "password" => Hash::make("testuser")
        ]);

        // run command to create roles for the user
        Artisan::call("shield:generate --all --panel=admin");
        Artisan::call("shield:super-admin --user=1 --panel=admin");
    }
}
