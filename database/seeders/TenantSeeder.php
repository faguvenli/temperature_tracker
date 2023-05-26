<?php

namespace Database\Seeders;

use App\Models\Tenant;
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
        $tenant1 = Tenant::create([
            'id' => 1,
            'name' => 'İl Sağlık Müdürlüğü',
            'database' => 'iot_ilsaglik'
        ]);
        $tenant2 = Tenant::create([
            'id' => 2,
            'name' => 'OMÜ Tıp Fakültesi',
            'database' => 'iot_omu'
        ]);
    }
}
