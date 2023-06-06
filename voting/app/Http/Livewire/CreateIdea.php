<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Idea;
use Livewire\Component;
use Response;
class CreateIdea extends Component
{
    public $category = 1;
    public $title;
    public $description;
    protected $rules = [
        'title' => 'required|min:4',
        'category' => 'required|integer',
        'description' => 'required|min:4',
    ];

    public function createIdea()
    {
        if (auth()->check()) {
            $this->validate();

            Idea::create([
                'user_id' => auth()->id(),
                'category_id' => $this->category,
                'status_id' => 1,
                'title' => $this->title,
                'description' => $this->description,
            ]);

            session()->flash("success_message", "Idea was created Successfully!");
            $this->reset();
            return redirect("/");
        }
        abort(403);

    }
    public function render()
    {
        return view(
            'livewire.create-idea',
            [
                'categories' => Category::all(),
            ]
        );
    }
}