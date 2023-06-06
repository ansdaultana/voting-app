<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use App\Models\Status;
use App\Models\Vote;
use Livewire\Component;
use Livewire\WithPagination;

class IdeasIndex extends Component
{

   // use WithPagination;
    public function render()
    {

        $statuses=Status::all()->pluck('id','name');

        return view('livewire.ideas-index',[
            "ideas" => Idea::with("user", "category", "status")
                //checking status filters in search query add by statusfilters
                ->when(request()->status && request()->status !== 'All', function ($query) use ($statuses) {
                    return $query->where('status_id', $statuses->get(request()->status));
                })
                //subquery for finding if user has voted for each idea while extracting all ideas
                ->addSelect(['voted_by_user'=>Vote::select('id')
                ->where('user_id',auth()->id())
                ->whereColumn('idea_id','ideas.id')
                  ])
                //now it will look for method votes
                //which are in votes table
                //so it will use eloquent relationship automaatically
                ->withCount('votes')
                ->orderBy("created_at", "desc")
                ->Paginate(Idea::PAGINATE_COUNT)
        ]);
    }
}
