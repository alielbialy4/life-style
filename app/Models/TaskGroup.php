<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskGroup extends Model
{
    use HasFactory;
    protected $fillable=['title_en','title_ar'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
