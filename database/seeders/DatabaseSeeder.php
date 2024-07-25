<?php

namespace Database\Seeders;

use App\Enums\ClassStanding;
use App\Enums\Gender;
use App\Models\Sport;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Ian Kollipara',
            'email' => 'ian.kollipara@cune.edu',
            'class_standing' => ClassStanding::Graduate(),
            'is_admin' => true,
            'gender' => Gender::Male(),
        ]);

        $basketball = Sport::create([
            'name' => 'Basketball',
            'description' => 'A sport where you shoot a ball into a hoop.',
        ]);

        $soccer = Sport::create([
            'name' => 'Soccer',
            'description' => 'A sport where you kick a ball into a goal.',
        ]);

        $mens_basketball = $basketball->variants()->create([
            'name' => 'Men\'s Basketball',
            'description' => 'A sport where you shoot a ball into a hoop.',
            'max_number_of_teams' => 2,
            'average_duration' => 60,
            'max_team_size' => 10,
        ]);

        $womens_basketball = $basketball->variants()->create([
            'name' => 'Women\'s Basketball',
            'description' => 'A sport where you shoot a ball into a hoop.',
            'max_number_of_teams' => 2,
            'average_duration' => 60,
            'max_team_size' => 10,
        ]);

        /** @var \App\Models\Variant */
        $mens_soccer = $soccer->variants()->create([
            'name' => 'Men\'s Soccer',
            'description' => 'A sport where you kick a ball into a goal.',
            'max_number_of_teams' => 2,
            'average_duration' => 60,
            'max_team_size' => 20,
        ]);

        $womens_soccer = $soccer->variants()->create([
            'name' => 'Women\'s Soccer',
            'description' => 'A sport where you kick a ball into a goal.',
            'max_number_of_teams' => 2,
            'average_duration' => 60,
        ]);

        $womens_soccer->coordinators()->attach($user);
        $mens_basketball->coordinators()->attach($user);
        $womens_basketball->coordinators()->attach($user);
        $mens_soccer->coordinators()->attach($user);

        $mens_basketball->seasons()->create([
            'description' => fake()->paragraphs(asText: true),
            'registration_start' => now(),
            'registration_end' => '2024-12-01',
            'start_date' => '2025-01-01',
            'end_date' => '2025-05-01',
        ]);

        $womens_basketball->seasons()->create([
            'description' => fake()->paragraphs(asText: true),
            'registration_start' => '2021-12-01',
            'registration_end' => '2022-01-01',
            'start_date' => '2022-01-01',
            'end_date' => '2022-05-01',
        ]);

        $mens_soccer->seasons()->create([
            'description' => fake()->paragraphs(asText: true),
            'registration_start' => '2021-12-01',
            'registration_end' => '2022-01-01',
            'start_date' => '2022-01-01',
            'end_date' => '2022-05-01',
        ]);

        $womens_soccer->seasons()->create([
            'description' => fake()->paragraphs(asText: true),
            'registration_start' => '2021-12-01',
            'registration_end' => '2022-01-01',
            'start_date' => '2022-01-01',
            'end_date' => '2022-05-01',
        ]);
    }
}
