<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return $this->successResponse(
            UserResource::collection($users),
            'Lista de usuários recuperada com sucesso.'
        );
    }

    public function store(UserRequest $request)
    {
        $validatedData = $request->validated();
        $user = $this->userService->createUser($validatedData);

        return $this->successResponse(
            new UserResource($user),
            'Usuário criado com sucesso.',
            201
        );
    }

    public function show($id)
    {
        return $this->handleModelNotFound(function () use ($id) {
            $user = $this->userService->getUserById($id);
            return $this->successResponse(
                new UserResource($user),
                'Usuário recuperado com sucesso.'
            );
        });
    }

    public function update(UserRequest $request, User $user)
    {
        $updatedUser = $this->userService->updateUser($user->id, $request->validated());
        return $this->successResponse(
            new UserResource($updatedUser),
            'Usuário atualizado com sucesso.'
        );
    }
    
    public function destroy($id)
    {
        return $this->handleModelNotFound(function () use ($id) {
            $this->userService->deleteUser($id);
            return $this->successResponse(null, 'Usuário excluído com sucesso.', 200);
        });
    }
}
