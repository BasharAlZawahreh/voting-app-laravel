<?php

namespace App\Models;

use App\Http\Livewire\IdeasIndex;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function idea()
    {
        $this->belongsTo(Idea::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }

    
}
