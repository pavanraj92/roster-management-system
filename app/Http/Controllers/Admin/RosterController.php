<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class RosterController extends Controller
{
    public function index()
    {
        return view('admin.roster.index');
    }
}
