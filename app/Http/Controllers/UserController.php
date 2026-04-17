<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'tipo' => 'nullable|string|in:USER,LOJISTA',
        ]);

        $user = $this->userService->createUser($validated);

        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'password' => 'sometimes|required|string|min:6',
        ]);

        $updatedUser = $this->userService->updateUser($user->id, $validated);

        return response()->json($updatedUser);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        
        $this->userService->deleteUser($user->id);

        return response()->json(null, 204);
    }
}
