<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'tenant_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'isSuperAdmin' => true,
            'isPanelUser' => true,
        ]);

        $user1->assignRole(1);

        $user2 = User::create([
            'tenant_id' => 2,
            'name' => 'Omü Kullanıcı',
            'email' => 'omu@user.com',
            'password' => bcrypt('omu'),
            'isSuperAdmin' => false
        ]);

        $user2->assignRole(1);

        $user3 = User::create([
            'tenant_id' => 1,
            'name' => 'İl Sağlık Kullanıcı',
            'email' => 'ilsaglik@user.com',
            'password' => bcrypt('ilsaglik'),
            'isSuperAdmin' => false
        ]);

        $user3->assignRole(1);
    }
}
