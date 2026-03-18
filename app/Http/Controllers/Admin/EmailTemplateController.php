<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Http\Requests\Admin\EmailTemplateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EmailTemplateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = EmailTemplate::query()->latest();

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    $search = $request->get('search');
                    $keyword = trim((string) ($search['value'] ?? ''));
                    if ($keyword !== '') {
                        $query->where(function ($q) use ($keyword) {
                            $q->where('name', 'like', '%' . $keyword . '%')
                                ->orWhere('subject', 'like', '%' . $keyword . '%');
                        });
                    }
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch text-center">
                                <input class="form-check-input toggle-status"
                                    type="checkbox"
                                    data-id="' . $row->id . '"
                                    data-url="' . route('admin.email-templates.toggle-status', $row->id) . '"
                                    ' . $checked . '>
                            </div>';
                })

                ->addColumn('action', function ($row) {
                    return '
                        <div class="text-end">
                            <a href="' . route('admin.email-templates.edit', $row->id) . '" class="me-2">
                                <i class="material-icons md-edit text-warning"></i>
                            </a>

                            <form action="' . route('admin.email-templates.destroy', $row->id) . '"
                                  method="POST"
                                  class="d-inline delete-form"
                                  data-module="Email Template">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="border-0 bg-transparent p-0">
                                    <i class="material-icons md-delete_forever text-danger"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.email_templates.index');
    }

    public function create()
    {
        return view('admin.email_templates.create');
    }

    public function store(EmailTemplateRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status');

        EmailTemplate::create($data);

        return redirect()
            ->route('admin.email-templates.index')
            ->with('success', 'Email Template created successfully.');
    }

    public function edit(EmailTemplate $email_template)
    {
        return view('admin.email_templates.edit', compact('email_template'));
    }

    public function update(EmailTemplateRequest $request, EmailTemplate $email_template)
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status');

        $email_template->update($data);

        return redirect()
            ->route('admin.email-templates.index')
            ->with('success', 'Email Template updated successfully.');
    }

    public function destroy(Request $request, EmailTemplate $email_template)
    {
        $email_template->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Email Template deleted successfully.'
            ]);
        }

        return redirect()
            ->route('admin.email-templates.index')
            ->with('success', 'Email Template deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $template->status = !$template->status;
        $template->save();

        return response()->json([
            'success' => true,
            'status' => $template->status
        ]);
    }
}