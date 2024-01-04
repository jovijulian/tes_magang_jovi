<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'userid' => '1',
            'email' => "admin@admin.com",
            'password' => Hash::make("test1234"),
            'name' => "Admin",
            'username' => "admin",
        ]);
    }
}