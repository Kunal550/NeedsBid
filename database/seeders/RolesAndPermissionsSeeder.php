<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        Permission::create(['name' => 'post projects']);
        Permission::create(['name' => 'bid on projects']);
        Permission::create(['name' => 'edit profile']);

        // Define roles and assign permissions
        $client = Role::create(['name' => 'Client']);
        $engineer = Role::create(['name' => 'Engineer']);
        $contractor = Role::create(['name' => 'Contractor']);
        $subContractor = Role::create(['name' => 'Sub Contractor']);
        $supplier = Role::create(['name' => 'Supplier']);

        // Assign permissions to roles
        $client->givePermissionTo(['post projects', 'edit profile']);
        $engineer->givePermissionTo(['bid on projects', 'edit profile']);
        $contractor->givePermissionTo(['bid on projects', 'edit profile']);
        $subContractor->givePermissionTo(['bid on projects', 'edit profile']);
        $supplier->givePermissionTo(['edit profile']);
    }
}
