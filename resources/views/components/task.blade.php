@use('App\Enums\TaskStatus')
@props(['task' => (object) ['task_status' => TaskStatus::PENDING, 'id' => null, 'task' => null], 'create' => null])
<td class="col-10">
    <div class="input-group">
        <div class="input-group-text">
            <input class="form-check-input" type="checkbox" @checked($task->task_status === TaskStatus::COMPLETED) value="">
        </div>
        <input type="text"
            @class(["form-control","text-decoration-line-through" => $task->task_status === TaskStatus::COMPLETED])
            aria-label="Text input with checkbox"
            @if (empty($create)) disabled
        @else @endif
            value="{{ $task->task }}">
    </div>
</td>
<td class="status">
    {{ $task->task_status->label() }}
</td>
