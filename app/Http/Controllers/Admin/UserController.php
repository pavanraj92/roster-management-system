<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
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
        return $request->ajax()
            ? $this->userService->getUserDataTable($request)
            : view('admin.user.index');
    }

    public function create()
    {
        return view('admin.user.create', [
            'roles' => Role::assignable()->get()
        ]);
    }

    public function store(UserRequest $request)
    {
        $this->userService->createUser($request->validated(), $request->has('status'));

        return redirect()->route('admin.user.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->loadMissing('roles:id,name');

        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->loadMissing('roles:id,name');

        return view('admin.user.edit', [
            'user' => $user,
            'roles' => Role::assignable()->get()
        ]);
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
