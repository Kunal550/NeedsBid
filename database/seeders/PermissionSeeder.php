<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions =[
            "role-list",
            "role-create",
            "role-edit",
            "role-delete",
            "user-list",
            "user-create",
            "user-edit",
            "user-delete",
            "project_category-list",
            "project_category-create",
            "project_category-edit",
            "project_category-delete",
            "project-list",
            "project-create",
            "project-edit",
            "project-delete"
        ];
        foreach ($permissions as $key => $permissions) {
            Permission::create(['name' => $permissions]);
        }
    }
}
