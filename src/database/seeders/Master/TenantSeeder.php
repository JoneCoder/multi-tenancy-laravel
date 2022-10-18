<?php

namespace Database\Seeders\Master;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tenant::create([
            'name'          => 'Test Domain',
            'email'         => 'example@gmail.com',
            'subdomain'     => 'test',
            'db_name'       => 'test',
            'admin_id'      => 1,
        ]);
    }
}
