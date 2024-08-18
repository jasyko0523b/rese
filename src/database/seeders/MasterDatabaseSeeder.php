<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class MasterDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'global_admin']);
        $shopAdminRole = Role::create(['name' => 'shop_admin']);

        $adminPermission = Permission::create(['name' => 'admin']);
        $ownerPermission = Permission::create(['name' => 'owner']);

        $adminRole->givePermissionTo($adminPermission);
        $shopAdminRole->givePermissionTo($ownerPermission);

        for ($i = 1; $i < 20; $i++) {
            $owner = User::factory()->create([
                'email' => 'owner' . $i . '@sample.com',
                'password' => bcrypt('owner' . $i),
            ]);
            $owner->assignRole($shopAdminRole);
        }

        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@sample.com',
            'password' => bcrypt('admin'),
        ]);

        $admin->assignRole($adminRole);
        $owner->assignRole($shopAdminRole);
    }
}
