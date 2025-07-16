<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $posts = [];

        for ($i = 1; $i <= 5; $i++) {
            $title = $faker->sentence(1, true);

            $posts[] = [
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => $faker->paragraphs(1, true),
                'summary' => $faker->sentence(2, true),
                'status' => $faker->randomElement(['published', 'draft']),
                'user_id' => $faker->numberBetween(1, 3),
                'published_date' => $faker->dateTimeBetween('-1 year', 'now'),
                'author_name' => $faker->name(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('posts')->insert($posts);
    }
}
