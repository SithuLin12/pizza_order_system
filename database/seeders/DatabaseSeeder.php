<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'sithulin',
            'email' => 'sithu@gmail.com',
            'phone' => '097845123',
            'gender' => 'male',
            'address' => 'yangon',
            'role' => 'admin',
            'password' => Hash::make('admin123')
        ]);
    }
}
