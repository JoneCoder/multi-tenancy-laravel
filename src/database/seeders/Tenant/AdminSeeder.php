<?php

namespace Database\Seeders\Tenant;

use App\Models\Tenant\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
             'name'     => auth()->user()->name,
             'email'    => auth()->user()->email,
             'password' => auth()->user()->getAuthPassword()
         ]);
    }
}
