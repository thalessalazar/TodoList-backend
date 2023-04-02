<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
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

    public function show()
    {

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
}
