<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $userId = DB::table('users')->insertGetId([
        'id' => 3,
        'name' => 'new',
        'email' => 'new@gmail.com',
        'password' => bcrypt('12345678'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Inserting a role
    $roleId = DB::table('roles')->insertGetId([
        'name' => 'employee',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Inserting into role_user table
    DB::table('role_user')->insert([
        'role_id' => $roleId,
        'user_id' => $userId,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}
}
