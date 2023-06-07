<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\Vote;
use Livewire\Component;
use Livewire\WithPagination;

class IdeasIndex extends Component
{

    use WithPagination;
    public $status;
    public $category;

    protected $queryString = [
        'status',
        'category',
    ];

    protected $listeners = ['queryStringUpdatedStatus'];

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->status = $this->status ?? 'All';
    }



    public function queryStringUpdatedStatus($newStatus)
    {
        $this->resetPage();
        $this->status = $newStatus;
    }

    public function render()
    {
        $statuses = Status::all()->pluck('id', 'name');
        $categories = Category::all();
        return view(
            'livewire.ideas-index',
            [
                "ideas" => Idea::with("user", "category", "status")
                    //checking status filters in search query add by statusfilters
                    ->when($this->status && $this->status !== 'All', function ($query) use ($statuses) {
                        return $query->where('status_id', $statuses->get($this->status));
                    })
                    //subquery for finding if user has voted for each idea while extracting all ideas
                    ->addSelect([
                        'voted_by_user' => Vote::select('id')
                            ->where('user_id', auth()->id())
                            ->whereColumn('idea_id', 'ideas.id')
                    ])
                    //now it will look for method votes
                    //which are in votes table
                    //so it will use eloquent relationship automaatically
                    ->withCount('votes')
                    ->orderBy("created_at", "desc")
                    ->Paginate(Idea::PAGINATE_COUNT),
                'categories' => $categories
            ]
        );
    }
}