<?php

namespace App\Models;

use App\Exceptions\DuplicateVoteException;
use App\Exceptions\VotNotFoundException;
use App\Models\Category;
use App\Models\Status;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory;
    use Sluggable;
    const PAGINATE_COUNT = 10;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'category_id',
        'status_id'
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user()
    {

        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //the votes of each idea belongs to many users by table called votes
    public function votes()
    {
        return $this->belongsToMany(User::class, 'votes');
    }

    public function isVotedByUser(?User $user)
    {
        if (!$user) {
            return false;
        }
        return Vote::where('user_id', $user->id)
            ->where('idea_id', $this->id)
            ->exists();
    }

    public function vote(User $user)
    {
        
        if ($this->isVotedByUser($user)) {
            throw new DuplicateVoteException;
        }
        
        Vote::create([
            'idea_id' => $this->id,
            'user_id' => $user->id
        ]);
    }  
    public function removeVote(User $user)
    {
      $foundVote=  Vote::where(
            'idea_id', $this->id)
            ->where(
            'user_id' , $user->id
        )->first();
        if ($foundVote) {
            # code...
            $foundVote->delete();

        }
        else
        {
            throw new VotNotFoundException;
        }
    }
}