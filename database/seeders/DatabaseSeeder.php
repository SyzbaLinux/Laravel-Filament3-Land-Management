<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'Administrator User',
             'email' => 'admin@example.com',
             'password' =>  Hash::make('Pass_12345'),
         ]);

         \App\Models\Project::create([
             'name' => 'Teachers Union',
             'slug' => 'teachers-union',
         ]);

         \App\Models\Setting::create([
            'company_name'  =>'Company Name',
            'address'       =>'Company Address',
            'email'         =>'info@example.com',
            'logo'          =>'/images/logo.png',
         ]);

         DB::table('project_user')->insert([
             'user_id' => 1,
             'project_id'  => 1,
         ]);
    }
}
