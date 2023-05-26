<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_groups = [
            ["id" => 1, "name" => "Ayarlar", "sort_order" => 3],
            ["id" => 2, "name" => "Çanta Cihazları", "sort_order" => 1],
            ["id" => 3, "name" => "Çevre Cihazları", "sort_order" => 2],
        ];

        foreach($permission_groups as $permission_group) {
            PermissionGroup::create($permission_group);
        }

        $permissions = [
            ['name' => 'Kullanıcı - Görüntüle', 'permission_group_id' => 1],
            ['name' => 'Kullanıcı - Ekle', 'permission_group_id' => 1],
            ['name' => 'Kullanıcı - Düzenle', 'permission_group_id' => 1],
            ['name' => 'Kullanıcı - Sil', 'permission_group_id' => 1],

            ['name' => 'Yetki - Görüntüle', 'permission_group_id' => 1],
            ['name' => 'Yetki - Ekle', 'permission_group_id' => 1],
            ['name' => 'Yetki - Düzenle', 'permission_group_id' => 1],
            ['name' => 'Yetki - Sil', 'permission_group_id' => 1],

            ['name' => 'Bölge - Görüntüle', 'permission_group_id' => 1],
            ['name' => 'Bölge - Ekle', 'permission_group_id' => 1],
            ['name' => 'Bölge - Düzenle', 'permission_group_id' => 1],
            ['name' => 'Bölge - Sil', 'permission_group_id' => 1],

            ['name' => 'Data Kartı - Görüntüle', 'permission_group_id' => 2],
            ['name' => 'Data Kartı - Ekle', 'permission_group_id' => 2],
            ['name' => 'Data Kartı - Düzenle', 'permission_group_id' => 2],
            ['name' => 'Data Kartı - Sil', 'permission_group_id' => 2],

            ['name' => 'Çanta Cihazı - Görüntüle', 'permission_group_id' => 2],
            ['name' => 'Çanta Cihazı - Ekle', 'permission_group_id' => 2],
            ['name' => 'Çanta Cihazı - Düzenle', 'permission_group_id' => 2],
            ['name' => 'Çanta Cihazı - Sil', 'permission_group_id' => 2],

            ['name' => 'Çanta Cihaz Tipi - Görüntüle', 'permission_group_id' => 2],
            ['name' => 'Çanta Cihaz Tipi - Ekle', 'permission_group_id' => 2],
            ['name' => 'Çanta Cihaz Tipi - Düzenle', 'permission_group_id' => 2],
            ['name' => 'Çanta Cihaz Tipi - Sil', 'permission_group_id' => 2],

            ['name' => 'Çevre Cihazı - Görüntüle', 'permission_group_id' => 3],
            ['name' => 'Çevre Cihazı - Ekle', 'permission_group_id' => 3],
            ['name' => 'Çevre Cihazı - Düzenle', 'permission_group_id' => 3],
            ['name' => 'Çevre Cihazı - Sil', 'permission_group_id' => 3],

        ];

        foreach($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
