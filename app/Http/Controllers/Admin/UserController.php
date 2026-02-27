<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->userService->getUserDataTable($request);
        }

        return view('admin.user.index');
    }

    public function create()
    {
        $roles = Role::whereNotIn('name', ['admin'])->get();
        return view('admin.user.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $this->userService->createUser($request->validated(), $request->has('status'));

        return redirect()->route('admin.user.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::whereNotIn('name', ['admin'])->get();
        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(UserRequest $request, User $user)
    {
        $this->userService->updateUser($user, $request->validated(), $request->has('status'));

        return redirect()->route('admin.user.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(Request $request, User $user)
    {
        $this->userService->deleteUser($user);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully.'
            ]);
        }

        return redirect()->route('admin.user.index')
            ->with('success', 'User deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $user = $this->userService->toggleStatus((int) $id);

        return response()->json([
            'success' => true,
            'status' => $user->status
        ]);
    }
}
