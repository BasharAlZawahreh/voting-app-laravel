<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Category::factory(50)->create();

        Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);
        Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);
        Status::factory()->create(['name' => 'Considering', 'classes' => 'bg-gray-200']);
        Status::factory()->create(['name' => 'openNow', 'classes' => 'bg-blue text-white']);
        Status::factory()->create(['name' => 'openLater', 'classes' => 'bg-blue text-white']);

        User::factory()->create([
            'name' => 'Bashar',
            'email' => 'z@z.com'
        ]);

        User::factory(19)->create();

        Idea::factory(100)->create();

        //Generate unique votes and ensure idea_id and user_id are unique for each vote
        foreach (range(1, 20) as $user_id) {
            foreach (range(1, 100) as $idea_id) {
                if ($idea_id % 2 === 0) {
                    Vote::factory()->create([
                        'user_id' => $user_id,
                        'idea_id' => $idea_id
                    ]);
                }
            }
        }
    }
}
