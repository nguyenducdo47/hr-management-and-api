<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // DB::table('roles')->insert([
        //     ['name' => 'super_admin'],
        //     ['name' => 'employee'],
        //     ['name' => 'team_lead'],
        // ]);

        // User::factory(10)->create();

        $superAdminRoleId = DB::table('roles')->where('name', 'super_admin')->first()->id;

        User::factory()->create([
            'name' => 'Admin123',
            'email' => 'admin123@gmail.com',
            'password' => Hash::make('12345678'),
            'role_id' => $superAdminRoleId,
        ]);


    }
}
