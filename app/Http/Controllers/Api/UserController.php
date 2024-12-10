<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCollectionRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserResourceCollection;
use App\Models\User;
use App\Repositories\User\UserRepositoryContract;
use Illuminate\Http\JsonResponse;

final class UserController extends Controller
{
    /**
     * @param UserCollectionRequest $request
     * @param UserRepositoryContract $repository
     * @return JsonResponse
     *
     * GET /users
     * Parameter(name="sort", in="query", description="sort by name")
     * Parameter(name="name", in="query", description="filter by name")
     * Response(response=200, data = "JsonContent", description="Successful")
     */
    public function index(UserCollectionRequest $request, UserRepositoryContract $repository): JsonResponse
    {
        $request->validated();
        return $this->resourceJsonCollection(
            fn() => $repository->findBy($request->get('name')),
            UserResourceCollection::class,
        );
    }

    /**
     * @param UserStoreRequest $request
     * @return JsonResponse
     *
     * POST /users
     * requestBody,
     * Response(response=201, description="Successful")
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return $this->resourceStored(UserResource::make($user));
    }

    /**
     * @param int $id
     * @param UserRepositoryContract $repository
     * @return JsonResponse
     *
     * GET /users/{id}
     * Parameter(name="id", required=true, in="path")
     * Response(response=200, description="Successful")
     * Response(response="404", description="Not found")
     */
    public function show(int $id, UserRepositoryContract $repository): JsonResponse
    {
        return $this->resourceShow(UserResource::make($repository->get($id)));
    }

    /**
     * @param int $id
     * @param UserUpdateRequest $request
     * @param UserRepositoryContract $repository
     * @return JsonResponse
     *
     * PUT /users/{id}
     * requestBody,
     * Parameter(name="id", required=true, in="path")
     * Response(response=200, description="Successful")
     * Response(response="404", description="Not found")
     */
    public function update(int $id, UserUpdateRequest $request, UserRepositoryContract $repository): JsonResponse
    {
        $user = $repository->get($id);
        $user->update($request->validated());

        return $this->resourceUpdated(UserResource::make($user));
    }

    /**
     * @param int $id
     * @param UserRepositoryContract $repository
     * @return JsonResponse
     *
     * Delete /users/{id}
     * Parameter(name="id", required=true, in="path")
     * Response(response=204, description="Successful")
     * Response(response="404", description="Not found")
     */
    public function destroy(int $id, UserRepositoryContract $repository): JsonResponse
    {
        $user = $repository->get($id);
        $user->delete();

        return $this->resourceDeleted();
    }
}
