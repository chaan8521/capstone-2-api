<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Registrar',
            'email' => 'academic_head@gmail.com',
            'password' => Hash::make('@Admin123'),
            'department_id' => 1,
            'type' => 'ALL',
            'status' => 'Active',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
