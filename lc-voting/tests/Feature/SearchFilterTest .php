<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeaShow;
use App\Http\Livewire\IdeasIndex;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SearchFilterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function searching_filter_works_when_more_than_3_characters()
    {

        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description of my first idea',
        ]);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My Second Idea',
            'description' => 'Description of my first idea',
        ]);

        $ideaTow = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My Third Idea',
            'description' => 'Description of my first idea',
        ]);


        Livewire::test(IdeasIndex::class)
            ->set('search', 'Second')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 1
                    && $ideas->first()->title === 'My Second Idea';
            });
    }

      /** @test */
      public function searching_filter_does_not_work_when_less_than_3_characters()
      {

          $user = User::factory()->create();

          $categoryOne = Category::factory()->create(['name' => 'Category 1']);
          $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

          $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

          $idea = Idea::factory()->create([
              'user_id' => $user->id,
              'category_id' => $categoryOne->id,
              'status_id' => $statusOpen->id,
              'title' => 'My First Idea',
              'description' => 'Description of my first idea',
          ]);

          $ideaOne = Idea::factory()->create([
              'user_id' => $user->id,
              'category_id' => $categoryOne->id,
              'status_id' => $statusOpen->id,
              'title' => 'My Second Idea',
              'description' => 'Description of my first idea',
          ]);

          $ideaTow = Idea::factory()->create([
              'user_id' => $user->id,
              'category_id' => $categoryOne->id,
              'status_id' => $statusOpen->id,
              'title' => 'My Third Idea',
              'description' => 'Description of my first idea',
          ]);


          Livewire::test(IdeasIndex::class)
              ->set('search', 'Se')
              ->assertViewHas('ideas', function ($ideas) {
                  return $ideas->count() === 3;
              });
      }

       /** @test */
    public function searching_filter_works_correctly_with_categories_filter()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description of my first idea',
        ]);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My Second Idea',
            'description' => 'Description of my first idea',
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryTwo->id,
            'status_id' => $statusOpen->id,
            'title' => 'My Third Idea',
            'description' => 'Description of my first idea',
        ]);


        Livewire::test(IdeasIndex::class)
            ->set('category', 'Category 1')
            ->set('search', 'Idea')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 2;
            });
    }

}
