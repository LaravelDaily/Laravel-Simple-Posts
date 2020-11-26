<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'post_create',
            ],
            [
                'id'    => 2,
                'title' => 'post_show',
            ],
            [
                'id'    => 3,
                'title' => 'post_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
