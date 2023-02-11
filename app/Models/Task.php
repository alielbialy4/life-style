<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable=['title_en','title_ar','time','status','task_groups_id'];

    public function task_group() {

        return $this->belongsTo(TasksGroup::class);
    }
    public function users() {

        return $this->belongsToMany(User::class);
    }
}
