<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Todo extends Model
{
    use HasFactory;

    protected $guarded = [];

    /*
     * belongsTo karena one to many
     * atau 1 user (tidak jamak) 
     * 1 user dapat memiliki banyak todo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
