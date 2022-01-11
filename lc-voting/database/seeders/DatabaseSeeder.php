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

        Status::factory()->create(['name' => 'Open']);
        Status::factory()->create(['name' => 'Closed']);
        Status::factory()->create(['name' => 'Considering']);
        Status::factory()->create(['name' => 'openNow']);
        Status::factory()->create(['name' => 'openLater']);

        Idea::factory(30)->create();
    }
}
