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


    protected $listeners = [
        'statusWasUpdated',
        'ideaWasUpdated',
        'ideaWasMarkedAsSpam',
        'ideaWasMarkedAsNotSpam',
        'commentWasAdded',
        'commentWasDeleted',
    ];

    public function mount(Idea $idea, $votesCount)
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->hasVoted = $idea->isVotedByUser(auth()->user());
    }

    public function ideaWasMarkedAsSpam()
    {
        $this->idea->refresh();
    }

    public function ideaWasMarkedAsNotSpam()
    {
        $this->idea->refresh();
    }
    public function statusWasUpdated()
    {
        $this->idea->refresh();
    }
    public function commentWasAdded()
    {
        $this->idea->refresh();
    }
    public function commentWasDeleted()
    {
        $this->idea->refresh();
    }
    public function ideaWasUpdated()
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
            $this->hasVoted = false;
            $this->votesCount--;

        } else {
            try {
                $this->idea->vote(auth()->user());
            } catch (DuplicateVoteException $e) {
                // do nothing
            }
            $this->hasVoted = true;
            $this->votesCount++;
        }

    }
    public function render()
    {
        return view('livewire.idea-show');
    }
}