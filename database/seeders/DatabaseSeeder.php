<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\JobPost;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 posters and 10 viewers
        $posters = User::factory(5)->create([
            'role' => 'poster',
            'password' => Hash::make('password'),
        ]);
        $viewers = User::factory(10)->create([
            'role' => 'viewer',
            'password' => Hash::make('password'),
        ]);

        // Each poster creates 5 JobPosts
        $posters->each(function ($poster) {
            JobPost::factory(5)->create([
                'user_id' => $poster->id,
            ])->each(function ($jobPost) {
                $createdAt = now()
                    ->subDays(rand(0, 30))
                    ->addHours(rand(0, 23))
                    ->addMinutes(rand(0, 59));
        
                $jobPost->created_at = $createdAt;
                $jobPost->updated_at = $createdAt;
                $jobPost->save();
            });
        });

        // Randomly add interested viewers to some job_posts
        $allJobPosts = JobPost::all();

        $viewers->each(function ($viewer) use ($allJobPosts) {
            $interestedJobs = $allJobPosts->random(rand(1, 3));
            foreach ($interestedJobs as $job) {
                $viewer->interestedJobPosts()->syncWithoutDetaching([$job->id]);
            }
        });

        // Add a fixed account for testing
        User::factory()->create([
            'name' => 'Admin Poster',
            'email' => 'poster@example.com',
            'role' => 'poster',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Viewer Demo',
            'email' => 'viewer@example.com',
            'role' => 'viewer',
            'password' => Hash::make('password'),
        ]);
    }
}
