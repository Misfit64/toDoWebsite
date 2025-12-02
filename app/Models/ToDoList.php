<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ToDoList extends Model
{
    protected $table = 'to_do_list';
    protected $fillable = ["task","task_status","user_id","tags"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'task_status' => TaskStatus::class,
        ];
    }

}
