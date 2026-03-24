<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Requests\Task\TaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->taskService->getTaskDataTable($request);
        }

        return view('admin.tasks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $this->taskService->createTask($request->validated(), $request->user()->id);

        return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load('creator');
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('admin.tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $this->taskService->updateTask($task, $request->validated());

        return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Task $task)
    {
        $res = $this->taskService->deleteTask($task);

        if ($request->ajax()) {
            if ($res) {
                return response()->json(['success' => true, 'message' => 'Task deleted successfully.']);
            }
            return response()->json(['success' => false, 'message' => 'This task is already assigned']);
        } else {
            if ($res) {
                return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully.');
            }
            return redirect()->route('admin.tasks.index')->with('error', 'This task is already assigned.');
        }

        // $this->taskService->deleteTask($task);

        // if ($request->ajax() || $request->wantsJson()) {
        //     return response()->json(['success' => true, 'message' => 'Task deleted successfully.']);
        // }

        // return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully.');
    }
}
