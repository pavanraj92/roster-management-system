<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RosterService;
use Illuminate\Http\Request;

class RosterController extends Controller
{
    protected $rosterService;

    public function __construct(RosterService $rosterService)
    {
        $this->rosterService = $rosterService;
    }

    public function index(Request $request)
    {
        $data = $this->rosterService->getRosterData($request);
        if ($request->ajax()) {
            return view('admin.roster.partials.roster-table', $data)->render();
        }
        return view('admin.roster.index', $data);
    }

    public function store(Request $request)
    {
        $this->rosterService->createRoster($request->all());

        return response()->json([
            'status'  => true,
            'message' => 'Roster Assigned Successfully',
        ]);
        // return back()->with('success', 'Roster Assigned');
    }

}
