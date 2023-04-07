<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTodoTaskRequest;
use App\Http\Resources\TodoTaskResource;
use App\Models\TodoTask;
use Illuminate\Http\Request;

class TodoTaskController extends Controller
{
    public function __construct()
    {
    }

    public function update(TodoTask $task, UpdateTodoTaskRequest $request)
    {
        $input = $request->validated();
        $task->fill($input);
        $task->save();
        return new TodoTaskResource($task->fresh());
    }

    public function destroy(TodoTask $task): void
    {
        $task->delete();
        return;
    }
}
