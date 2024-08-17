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
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@sample.com',
            'password' => bcrypt('user'),
            'favorite' => [1, 2],
        ]);
        $admin = User::factory()->create([
            'name' => '社員admin',
            'email' => 'admin@sample.com',
            'password' => bcrypt('admin'),
        ]);
        $owner = User::factory()->create([
            'name' => '社員owner',
            'email' => 'owner@sample.com',
            'password' => bcrypt('owner'),
        ]);

        $adminRole = Role::create(['name' => 'global_admin']);
        $shopAdminRole = Role::create(['name' => 'shop_admin']);

        $adminPermission = Permission::create(['name' => 'admin']);
        $ownerPermission = Permission::create(['name' => 'owner']);

        $adminRole->givePermissionTo($adminPermission);
        $shopAdminRole->givePermissionTo($ownerPermission);

        $admin->assignRole($adminRole);
        $owner->assignRole($shopAdminRole);
    }
}
