<?php
declare(strict_types=1);

namespace App\Services\Response\Controller;

use App\Services\Response\Messages;
use App\Services\Response\Responses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

trait ResourceResponses
{

    /**
     * @param JsonResource $resource
     *
     * @return JsonResponse
     */
    public function resourceCollection(JsonResource $resource): JsonResponse
    {
        return $resource->additional(['message' => Messages::SUCCESS])->response();
    }

    /**
     * @param Closure|JsonResource|mixed $resource
     * @param string $resourceClass
     *
     * @return JsonResponse
     */
    public function resourceJsonCollection($resource, string $resourceClass): JsonResponse
    {
        if ($resource instanceof JsonResource) {
            return $this->resourceCollection($resource);
        }

        return $this->resourceCollection($resourceClass::make(is_callable($resource) ? $resource() : $resource));
    }

    /**
     * @param JsonResource $resource
     *
     * @return JsonResponse
     */
    public function resourceShow(JsonResource $resource): JsonResponse
    {
        return Responses::success($resource);
    }

    /**
     * @param JsonResource $resource
     *
     * @return JsonResponse
     */
    public function resourceStored(JsonResource $resource): JsonResponse
    {
        return Responses::success($resource, Messages::SUCCESS, Response::HTTP_CREATED);
    }

    /**
     * @param JsonResource $resource
     *
     * @return JsonResponse
     */
    public function resourceUpdated(JsonResource $resource): JsonResponse
    {
        return $resource->additional(['message' => Messages::SUCCESS])->response();
    }

    /**
     * @return JsonResponse
     */
    public function resourceDeleted(): JsonResponse
    {
        return Responses::noContent();
    }
}
