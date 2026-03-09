<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TaskService
{
    /**
     * Build DataTable response for tasks listing.
     */
    public function getTaskDataTable(Request $request)
    {
        $data = Task::query()->with('creator')->latest();

        return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                $search = $request->get('search');
                $keyword = $search['value'] ?? '';
                if ($keyword !== '') {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('title', 'like', '%' . $keyword . '%')
                            ->orWhere('description', 'like', '%' . $keyword . '%');
                    });
                }
            })
            ->addColumn('title', function ($row) {
                return e($row->title);
            })
            ->addColumn('description', function ($row) {
                return $row->description
                    ? Str::limit(strip_tags($row->description), 50)
                    : '<span class="text-muted">—</span>';
            })
            ->addColumn('created_by', function ($row) {
                return $row->creator
                    ? e($row->creator->name ?? $row->creator->email)
                    : '<span class="text-muted">—</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="text-end">
                            <a href="' . route('admin.tasks.show', $row->id) . '" class="me-2" title="View">
                                <i class="material-icons md-remove_red_eye" style="color: #28a745;"> </i>
                            </a>
                            <a href="' . route('admin.tasks.edit', $row->id) . '" class="me-2" title="Edit">
                                <i class="material-icons md-edit" style="color: #ffc107;"> </i>
                            </a>
                            <form action="' . route('admin.tasks.destroy', $row->id) . '" method="POST" class="d-inline delete-form" data-module="Task">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="border-0 bg-transparent p-0" title="Delete">
                                    <i class="material-icons md-delete_forever" style="color: #dc3545;"> </i>
                                </button>
                            </form>
                        </div>';
                return $btn;
            })
            ->rawColumns(['action', 'description'])
            ->make(true);
    }

    /**
     * Create a new task.
     */
    public function createTask(array $validated, int $createdBy): Task
    {
        $validated['created_by'] = $createdBy;

        return Task::create($validated);
    }

    /**
     * Update a task.
     */
    public function updateTask(Task $task, array $validated): Task
    {
        $task->update($validated);

        return $task;
    }

    /**
     * Delete a task (soft delete).
     */
    public function deleteTask(Task $task): bool
    {
        $task->delete();

        return true;
    }
}
