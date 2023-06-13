<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class IdeaComment extends Component
{
    public $comment;
    public $userid;

    protected $listeners = ['commentWasUpdated'];

    public function commentWasUpdated()
    {
        $this->comment->refresh();
    }

    public function mount(Comment $comment, $userid)
    {
        $this->comment = $comment;
        $this->userid = $userid;
    }

    public function render()
    {
        return view('livewire.idea-comment');
    }
}
