<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    protected $fillable = ['task_time','title','subject','user_id'];

    protected $table = 'tasks';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
