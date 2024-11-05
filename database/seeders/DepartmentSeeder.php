<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
  

        DB::table('departments')->insert([
            [
                'department' => 'ALL',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'department' => 'IT Department',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
