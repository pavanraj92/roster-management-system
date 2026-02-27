<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BannerSetting;
use App\Http\Requests\Admin\BannerSettingRequest;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BannerSetting::select('*')->latest();

            if ($request->has('status') && $request->status !== null && $request->status !== '') {
                $data->where('status', $request->status);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $url = $row->image ? asset('storage/' . $row->image) : asset('backend/imgs/theme/upload.svg');
                    return '<img src="' . $url . '" class="img-sm img-thumbnail" alt="Banner">';
                })
                ->editColumn('is_sub_banner', function ($row) {
                    $badges = '';
                    if ($row->is_sub_banner) {
                        $badges .= '<span class="badge rounded-pill bg-info text-white me-1">Sub Banner</span>';
                    }
                    if ($row->is_single_banner) {
                        $badges .= '<span class="badge rounded-pill bg-warning text-dark me-1">Single Banner</span>';
                    }
                    if (!$row->is_sub_banner && !$row->is_single_banner) {
                        $badges .= '<span class="badge rounded-pill bg-primary text-white me-1">Main Banner</span>';
                    }
                    return $badges;
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch text-center">
                                <input class="form-check-input toggle-status"
                                    type="checkbox"
                                    data-id="' . $row->id . '"
                                    data-url="' . route('admin.settings.banners.toggle-status', $row->id) . '"
                                    ' . $checked . '>
                            </div>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="text-end">
                                <a href="' . route('admin.settings.banners.show', $row->id) . '" class="me-2" title="View">
                                    <i class="material-icons md-remove_red_eye" style="color: #28a745;"> </i>
                                </a>
                                <a href="' . route('admin.settings.banners.edit', $row->id) . '" class="me-2" title="Edit">
                                    <i class="material-icons md-edit" style="color: #ffc107;"> </i>
                                </a>
                                <form action="' . route('admin.settings.banners.destroy', $row->id) . '" method="POST" class="d-inline delete-form" data-module="Banner">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="border-0 bg-transparent p-0" title="Delete">
                                        <i class="material-icons md-delete_forever" style="color: #dc3545;"> </i>
                                    </button>
                                </form>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['image', 'is_sub_banner', 'status', 'action'])
                ->make(true);
        }

        return view('admin.settings.banners.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.settings.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerSettingRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $data['status'] = $request->has('status') ? true : false;
        $data['is_sub_banner'] = $request->has('is_sub_banner') ? true : false;
        $data['is_single_banner'] = $request->has('is_single_banner') ? true : false;

        BannerSetting::create($data);

        return redirect()->route('admin.settings.banners.index')->with('success', 'Banner created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BannerSetting $banner)
    {
        return view('admin.settings.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BannerSetting $banner)
    {
        return view('admin.settings.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerSettingRequest $request, BannerSetting $banner)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $data['status'] = $request->has('status') ? true : false;
        $data['is_sub_banner'] = $request->has('is_sub_banner') ? true : false;
        $data['is_single_banner'] = $request->has('is_single_banner') ? true : false;

        $banner->update($data);

        return redirect()->route('admin.settings.banners.index')->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, BannerSetting $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Banner deleted successfully.'
            ]);
        }

        return redirect()->route('admin.settings.banners.index')->with('success', 'Banner deleted successfully.');
    }

    /**
     * Toggle the status.
     */
    public function toggleStatus(Request $request, $id)
    {
        $banner = BannerSetting::findOrFail($id);
        $banner->status = !$banner->status;
        $banner->save();

        return response()->json(['success' => true, 'status' => $banner->status]);
    }
}
