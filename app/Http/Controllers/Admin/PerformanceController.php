<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Services\PerformanceService;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function __construct(
        protected PerformanceService $performanceService
    ) {}

    public function index(Request $request)
    {
        dd('ddsdddddsdasdfsdf adssa dad ad sa');
        $shifts = Shift::all();
        if ($request->ajax()) {
            return $this->performanceService->getPerformanceDataTable($request);
        }

        return view('admin.performance.index', compact('shifts'));
    }

    public function show($id)
    {
        return $this->performanceService->showPerformance($id);
    }
}
