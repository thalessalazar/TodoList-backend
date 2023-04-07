<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTodoRequest;
use App\Http\Requests\CreateTodoTaskRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Http\Resources\TodoTaskResource;
use App\Models\Todo;

class TodoController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return TodoResource::collection(auth()->user()->todos()->latest()->get());
    }

    public function show(Todo $todo)
    {
        $todo->load('tasks');
        return new TodoResource($todo);
    }

    public function store(CreateTodoRequest $request)
    {
        $input = $request->validated();
        $todo = auth()->user()->todos()->create($input);

        return new TodoResource($todo);
    }

    public function update(Todo $todo, UpdateTodoRequest $request)
    {
        $input = $request->validated();
        $todo->fill($input);
        $todo->save();
        return new TodoResource(
            $todo->fresh()
        );
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return;
    }

    public function addTask(Todo $todo, CreateTodoTaskRequest $request)
    {
        $input = $request->validated();
        $todoTask = $todo->tasks()->create($input);
        return new TodoTaskResource($todoTask);
    }
}
