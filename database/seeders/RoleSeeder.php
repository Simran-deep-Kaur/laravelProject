<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    
    public function run(): int
    {
        $roleId = DB::table('roles')->insert([
            'name'=>('super-admin'),
            'created_at'=>(now()),
            'updated_at'=>(now()),
        ]);

        return $roleId;
    }
}