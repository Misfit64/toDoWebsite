<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ToDoList extends Model
{
    protected $table = 'to_do_list';
    protected $fillable = ["task","task_status","user_id"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
