<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = Permission::pluck('id');
        Role::findOrFail(1)->permissions()->sync($permissions);
        Role::findOrFail(2)->permissions()->sync($permissions);
    }
}
