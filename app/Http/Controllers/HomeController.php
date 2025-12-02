<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Models\ToDoList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $userId = Auth::user();

        $tasks = $userId->tasks()
        ->orderBy("task_status","asc")
        ->orderBy('updated_at','desc')->get();

        return view("home",["tasks"=> $tasks]);
    }

    public function create(Request $request){
        $task = $request->validate([
            "task"=> "required",
        ]);
        $user = Auth::user();
        $new_task = $user->tasks()->create([
                    "task"=> $task["task"],
                    "task_status"=>TaskStatus::PENDING->value,
                    ]);

        return response("$new_task->id
        ",200);
    }

    public function edit(Request $request, $id){
        $userId = Auth::user();
        $task = $userId->tasks()->find($id);

        if(!$task){
            abort(404);
        }
        $request->validate([
            "task"=> "required",
        ]);

        $task->update([
            'task' => $request->input('task'),
        ]);
        return response("",200);
    }

    public function update($id){
        $userId = Auth::user();
        $task = $userId->tasks()->find($id);

        if(!$task){
            abort(404);
        }
        $status= $task->update([
                    'task_status' => !$task->task_status->value,
                ]);

        return response($task->task_status->label(),200);
    }

    public function destroy($id){
        $userId = Auth::user();
        $task = $userId->tasks()->find($id);

        if($task){
            $task->delete();
            return response("",200);
        }
        abort(403);
    }

}
