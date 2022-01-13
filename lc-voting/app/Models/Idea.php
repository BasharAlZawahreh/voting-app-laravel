<?php

namespace App\Models;

use App\Exceptions\DublicateVoteException;
use App\Exceptions\VoteNotFoundException;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = [];
    const PAGINATION_COUNT = 10;

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

    public function vote()
    {
        if (!auth()->check()) {
            return redirect(route('login'));
        }

        if ($this->isVotedByUser(auth()->id())) {
            throw new DublicateVoteException;
        }

        Vote::create([
            'idea_id' => $this->id,
            'user_id' => auth()->id()
        ]);
    }

    public function unvote()
    {
        if (!auth()->check()) {
            return redirect(route('login'));
        }

        $voteToDelete = Vote::where('idea_id', $this->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($voteToDelete) {
            $voteToDelete->delete();
        }
        else{
            throw new VoteNotFoundException();
        }
    }
}
