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
            'name'          => 'Jone Domain',
            'email'         => 'jonecoder@gmail.com',
            'subdomain'     => 'jonecoder',
            'db_name'       => 'jonecoder',
            'admin_id'      => 1,
        ]);
    }
}
