<?php

namespace Database\Seeders;

use App\Models\Idea;
use App\Models\Status;
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
        Status::factory()->create(['name' => 'Open','classes'=>'bg-gray-200']);
        Status::factory()->create(['name' => 'Closed','classes'=>'bg-red text-white']);
        Status::factory()->create(['name' => 'Considering','classes'=>'bg-gray-200']);
        Status::factory()->create(['name' => 'openNow','classes'=>'bg-blue text-white']);
        Status::factory()->create(['name' => 'openLater','classes'=>'bg-blue text-white']);

        Idea::factory(30)->create();
    }
}
