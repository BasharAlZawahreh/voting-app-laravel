<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Idea;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class EditIdea extends Component
{
    public $idea;

    public $title;
    public $category;
    public $description;

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
        $this->title = $idea->title;
        $this->category = $idea->category_id;
        $this->description = $idea->description;
    }

    public function updateIdea()
    {
        // Auth >>> policies!
        if (auth()->guest() || auth()->user()->cannot('update', $this->idea)) {
            abort(HttpResponse::HTTP_FORBIDDEN);
        }
        // Validation
        $this->validate([
            'title' => 'required|max:255|min:4',
            'category' => 'required|integer|exists:categories,id',
            'description' => 'required|min:50'
        ]);

        // $this->idea->title = $this->title;
        $this->idea->update([
            'title' => $this->title,
            'category_id' => $this->category,
            'description' => $this->description
        ]);

        $this->emit('ideaWasUpdated', 'Idea was Updated Successfully!');
    }
    public function render()
    {
        return view('livewire.edit-idea', [
            'categories' => Category::all()
        ]);
    }
}
