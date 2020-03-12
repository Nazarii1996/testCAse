<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$WsYPvJBYJETCbQVuZP4O2ubIKdI00.pYWkhN//Z4qMlVxJ8UGmJqe',
                'remember_token' => null,
            ],
        ];

        User::insert($users);

    }
}
