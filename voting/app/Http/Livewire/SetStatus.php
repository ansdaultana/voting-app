<?php

namespace App\Http\Livewire;

use App\Jobs\NotifyAllVoters;
use App\Mail\IdeaStatusUpdatedMailable;
use App\Models\Idea;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;

class SetStatus extends Component
{ 
    public $idea;
    public $status;
    public $notifyAllUsers;
    public function mount(Idea $idea)
    {
        $this->idea = $idea;
        $this->status = $this->idea->status_id;
    }

    public function setStatus()
    {
        if ( auth()->guest() || ! auth()->user()->isAdmin()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->idea->status_id = $this->status;
        $this->idea->save();
        if ($this->notifyAllUsers) {
            NotifyAllVoters::dispatch($this->idea);
        }
        
        $this->emit('statusWasUpdated', 'Status was updated successfully!');
    }

   

    public function render()
    {
        return view('livewire.set-status');
    }
}
