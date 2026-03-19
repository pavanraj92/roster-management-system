<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Http\Requests\Admin\PageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{
    /**
     * Display listing
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Page::query();

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    $search = $request->get('search');
                    $keyword = trim((string) ($search['value'] ?? ''));
                    if ($keyword !== '') {
                        $query->where('title', 'like', '%' . $keyword . '%');
                    }
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch text-center">
                                <input class="form-check-input toggle-status"
                                    type="checkbox"
                                    data-id="' . $row->id . '"
                                    data-url="' . route('admin.pages.toggle-status', $row->id) . '"
                                    ' . $checked . '>
                            </div>';
                })

                ->addColumn('action', function ($row) {

                    return '
                        <div class="text-end">
                            <a href="' . route('admin.pages.show', $row->id) . '" class="me-2" title="View">
                                <i class="material-icons md-remove_red_eye text-success"></i>
                            </a>

                            <a href="' . route('admin.pages.edit', $row->id) . '" class="me-2" title="Edit">
                                <i class="material-icons md-edit text-warning"></i>
                            </a>

                            <form action="' . route('admin.pages.destroy', $row->id) . '"
                                  method="POST"
                                  class="d-inline delete-form"
                                  data-module="Page">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="border-0 bg-transparent p-0" title="Delete">
                                    <i class="material-icons md-delete_forever text-danger"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.pages.index');
    }

    /**
     * Create Form
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store Page
     */
    public function store(PageRequest $request)
    {
        $data = $request->validated();

        // Status Handle
        $data['status'] = $request->boolean('status');

        Page::create($data);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    /**
     * Show Page
     */
    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Edit Form
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update Page
     */
    public function update(PageRequest $request, Page $page)
    {
        $data = $request->validated();

        // Status Handle
        $data['status'] = $request->boolean('status');

        $page->update($data);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Request $request, Page $page)
    {
        $page->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Page deleted successfully.'
            ]);
        }

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    /**
     * Toggle Status
     */
    public function toggleStatus(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $page->status = !$page->status;
        $page->save();

        return response()->json([
            'success' => true,
            'status' => $page->status
        ]);
    }
}
