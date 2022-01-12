<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeaShow;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class VoteShowCount extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function show_page_contains_show_livewire_component()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description of my first idea',
        ]);

       $this->get(route('idea.show',$idea))
       ->assertSeelivewire('idea-show');
    }


    /** @test */
    public function show_page_correctly_recives_votes_count()
    {
        $user = User::factory()->create();
        $userB = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description of my first idea',
        ]);


        Vote::factory()->create([
            'user_id'=>$user->id,
            'idea_id'=>$idea->id
        ]);

        Vote::factory()->create([
            'user_id'=>$userB->id,
            'idea_id'=>$idea->id
        ]);

       $this->get(route('idea.show',$idea))
       ->assertViewHas('votesCount',2);
    }

     /** @test */
     public function votes_count_shows_correctly_on_show_page_livewire_compnent()
     {
         $user = User::factory()->create();

         $categoryOne = Category::factory()->create(['name' => 'Category 1']);

         $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

         $idea = Idea::factory()->create([
             'user_id' => $user->id,
             'category_id' => $categoryOne->id,
             'status_id' => $statusOpen->id,
             'title' => 'My First Idea',
             'description' => 'Description of my first idea',
         ]);

         Livewire::test(IdeaShow::class,[
             'idea'=>$idea,
             'votesCount'=>5
         ])
         ->assertSet('votesCount',5)
         ->assertSeeHtml('<div class="text-xl leading-snug">5</div>')
         ->assertSeeHtml('<div class="text-sm font-bold leading-none">5</div>');
     }
}
