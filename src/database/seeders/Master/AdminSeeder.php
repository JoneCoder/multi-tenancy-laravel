<?php

namespace Database\Seeders\Master;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name'     => 'Md. Shariful Islam',
            'username'     => 'JoneCoder',
            'email'    => 'jonecoder@gmail.com',
            'password' => Hash::make('password')
        ]);
    }
}
