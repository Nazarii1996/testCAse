<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => '1',
                'title' => 'user_management_access',
            ],
            [
                'id'    => '2',
                'title' => 'permission_create',
            ],
            [
                'id'    => '3',
                'title' => 'permission_edit',
            ],
            [
                'id'    => '4',
                'title' => 'permission_delete',
            ],
            [
                'id'    => '5',
                'title' => 'permission_access',
            ],
            [
                'id'    => '6',
                'title' => 'role_create',
            ],
            [
                'id'    => '7',
                'title' => 'role_edit',
            ],
            [
                'id'    => '8',
                'title' => 'role_delete',
            ],
            [
                'id'    => '9',
                'title' => 'role_access',
            ],
            [
                'id'    => '10',
                'title' => 'user_create',
            ],
            [
                'id'    => '11',
                'title' => 'user_edit',
            ],
            [
                'id'    => '12',
                'title' => 'user_delete',
            ],
            [
                'id'    => '13',
                'title' => 'user_access',
            ],
        ];

        Permission::insert($permissions);

    }
}
