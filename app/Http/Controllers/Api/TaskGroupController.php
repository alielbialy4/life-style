<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskGroupController extends BaseController
{
    public function index()
    {
        $tasksGroup = TaskGroup::all();
        return $tasksGroup;
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title_en' => 'required|max:255',
                'title_ar' => 'required|max:255',
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $taskGroup = TaskGroup::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar
        ]);

        return $this->sendResponse($taskGroup);
    }


    public function edit(Request $request , $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title_en' => 'required|max:255',
                'title_ar' => 'required|max:255',
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $taskGroup = TaskGroup::find($id);

        if($taskGroup){
            $item = $taskGroup->update([
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar
            ]);        
            return $this->sendResponse($item);
        }

        return $this->sendError('Validation Error');
        
    }

    public function delete($id){
        $item = TaskGroup::query()->findOrFail($id)->delete();
        return $this->sendResponse($item);

    }
}