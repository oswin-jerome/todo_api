<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $todos = Todo::orderBy("created_at", "desc");

        if ($request->has("user_id")) {
            $todos = $todos->where("user_id", "=", $request->user_id);
        }

        return response($todos->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|string",
            "completed" => "required|boolean",
            "user_id" => "required|integer"
        ]);

        $todo = Todo::create($request->all());

        return response($todo);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        return response($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            "completed" => "required|boolean"
        ]);

        $todo->completed = $request->completed;
        $todo->update();

        return $todo;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response(["message" => "deleted", 200]);
    }
}
