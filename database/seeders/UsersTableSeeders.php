<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class UsersTableSeeders extends Seeder
{
    public function run()
    {
        User::create([
            'name'     => 'Admin Pertama',
            'email'    => 'admin@example.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
