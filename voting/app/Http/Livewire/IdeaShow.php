<?php

namespace App\Http\Livewire;

use App\Exceptions\DuplicateVoteException;
use App\Exceptions\VotNotFoundException;
use App\Models\Idea;
use Livewire\Component;

class IdeaShow extends Component
{

    public $idea;
    public $votesCount;

    public $hasVoted;


protected $listeners=['statusWasUpdated'];

    public function mount(Idea $idea, $votesCount)
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->hasVoted = $idea->isVotedByUser(auth()->user());
    }


public function statusWasUpdated()
{
    $this->idea->refresh();
}

    public function vote()
    {
        if (!auth()->check()) {
           return redirect(route('login'));
            # code...
        }

      
        if ($this->hasVoted) {
            # code...
            try {
                $this->idea->removeVote(auth()->user());
            } catch (VotNotFoundException $e) {
                // do nothing
            }          
              $this->hasVoted=false;
            $this->votesCount--;

        }        
        else{
            try {
                $this->idea->vote(auth()->user());
            } catch (DuplicateVoteException $e) {
                // do nothing
            }
            $this->hasVoted=true;
            $this->votesCount++;
        }

    }
    public function render()
    {
        return view('livewire.idea-show');
    }
}