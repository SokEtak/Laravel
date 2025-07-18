<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//            'password' => '12345678',
//            'tenant_id'=> 1,
//            'role_id'=> 1,
//        ]);

        $this->call([
            StudentSeeder::class,
            TeacherSeeder::class,
            CourseSeeder::class,
        ]);
    }
}
