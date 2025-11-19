@props(['task' => (object) ['task_status' => '0', 'id' => null, 'task' => null], 'create' => null])
<td class="col-10">
    <div class="input-group">
        <div class="input-group-text">
            <input class="form-check-input" type="checkbox" @checked($task->task_status) value="">
        </div>
        <input type="text"
            class="form-control @if ($task->task_status) text-decoration-line-through" @endif
         aria-label="Text
            input with checkbox" @if (empty($create)) disabled
        @else @endif
            value="{{ $task->task }}">
    </div>
</td>
