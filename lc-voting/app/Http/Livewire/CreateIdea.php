<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Idea;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;

class CreateIdea extends Component
{

    public $title;
    public $category = 1;
    public $description;

    protected $rules = [
        'title'=>'required|max:255|min:4',
        'category'=>'required|integer',
        'description'=>'required|min:50'
    ];

    public function createIdea()
    {
        if (auth()->check()) {

            Idea::create([
                'user_id'=>auth()->id(),
                'category_id'=>$this->category,
                'status_id'=>1,
                'title'=>$this->title,
                'description'=>$this->description

            ]);
            session()->flash('success','idea added successfully!');

            $this->reset();

            return redirect()->route('idea.index');
        }

        abort(Response::HTTP_FORBIDDEN);

    }


    public function render()
    {
        return view('livewire.create-idea', [
            'categories' => Category::all()
        ]);
    }
}
