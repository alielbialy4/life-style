<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TaskGroup;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return $tasks;
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title_en' => 'required|max:255',
                'title_ar' => 'required|max:255',
                'time' => 'nullable',
                'status' => 'nullable|in:1,0',
                'task_groups_id' => 'required'
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $task = Task::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'status' => $request->status,
            'time' => $request->time,
            'task_groups_id' => $request->task_groups_id
        ]);


        // find user that add this task
        $id = Auth::guard('sanctum')->user()->id;
        $user = User::findOrFail($id);
        $user->tasks()->attach($task);

        // add task category to task
        $taskGroup = TaskGroup::findOrFail($request->task_groups_id);
        $taskGroup->tasks()->save($task);

        return $this->sendResponse($task);
    }


    public function edit(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title_en' => 'required|max:255',
                'title_ar' => 'required|max:255',
                'time' => 'nullable',
                'status' => 'nullable|in:1,0'
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $task = Task::find($id);

        if ($task) {
            $item = $task->update([
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar,
                'status' => $request->status,
                'time' => $request->time
            ]);
            return $this->sendResponse($item);
        }

        return $this->sendError('Validation Error');
    }

    public function delete($id)
    {
        $item = Task::query()->findOrFail($id)->delete();
        return $this->sendResponse($item);
    }

    
}
