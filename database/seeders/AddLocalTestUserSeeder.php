<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class AddLocalTestUserSeeder extends Seeder
{
    public function run(): void
    {
        // dump(App::environment());
        if (App::environment() === 'local') { // testing
            User::truncate();
            $user = User::create([
                'email' => 'test@test.com',
                'name' => 'Aled',
                'password' => bcrypt('password'),
            ]);

            $courses = Course::all();
            $user->purchasedCourses()->attach($courses);
        }
    }
}
