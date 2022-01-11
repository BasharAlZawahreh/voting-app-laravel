<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

    public function getStatusClasses()
    {
        $allStatuses = [
            'Open' => 'bg-gray-200',
            'Closed' => 'bg-red text-white',
            'Considering' => 'bg-blue text-white',
            'openNow' => 'bg-blue text-white',
            'openLater' => 'bg-blue text-white',
        ];

        return $allStatuses[$this->name];
    }
}
