<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Application\Plan\Create\CreatePlanDTO;
use App\Application\Plan\Create\CreatePlanUseCase;
use App\Application\Plan\Delete\DeletePlanUseCase;
use App\Application\Plan\List\ListPlansUseCase;
use App\Application\Plan\Update\UpdatePlanDTO;
use App\Application\Plan\Update\UpdatePlanUseCase;
use App\Domain\Plan\PlanRepositoryInterface;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Http\Resources\PlanResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PlanController extends Controller
{
    // Inyectamos todos los casos de uso y repositorios que necesitamos
    public function __construct(
        private readonly ListPlansUseCase $listPlansUseCase,
        private readonly CreatePlanUseCase $createPlanUseCase,
        private readonly UpdatePlanUseCase $updatePlanUseCase,
        private readonly DeletePlanUseCase $deletePlanUseCase,
        private readonly PlanRepositoryInterface $planRepository
    ) {}

    /**
     * @OA\Get(
     * path="/api/v1/plans",
     * summary="List all plans",
     * tags={"Plans"},
     * @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        $plans = $this->listPlansUseCase->execute();
        return PlanResource::collection($plans);
    }

    /**
     * @OA\Post(
     * path="/api/v1/plans",
     * summary="Create a new plan",
     * tags={"Plans"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/StorePlanRequest")
     * ),
     * @OA\Response(response=201, description="Plan created successfully"),
     * @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(StorePlanRequest $request): JsonResponse
    {
        $dto = new CreatePlanDTO(
            $request->validated('name'),
            $request->validated('price'),
            $request->validated('user_limit'),
            $request->validated('features', [])
        );

        $plan = $this->createPlanUseCase->execute($dto);

        return (new PlanResource($plan))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     * path="/api/v1/plans/{id}",
     * summary="Get a single plan by ID",
     * tags={"Plans"},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Successful operation"),
     * @OA\Response(response=404, description="Plan not found")
     * )
     */
    public function show(int $id): PlanResource
    {
        $plan = $this->planRepository->findById($id);

        if (!$plan) {
            abort(404, 'Plan no encontrado.');
        }

        return new PlanResource($plan);
    }

    /**
     * @OA\Put(
     * path="/api/v1/plans/{id}",
     * summary="Update a plan",
     * tags={"Plans"},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/UpdatePlanRequest")
     * ),
     * @OA\Response(response=200, description="Plan updated successfully"),
     * @OA\Response(response=404, description="Plan not found")
     * )
     */
    public function update(UpdatePlanRequest $request, int $id): PlanResource
    {
        $dto = new UpdatePlanDTO(
            $id,
            $request->validated('name'),
            $request->validated('price'),
            $request->validated('user_limit'),
            $request->validated('features', [])
        );

        $plan = $this->updatePlanUseCase->execute($dto);

        if (!$plan) {
            abort(404, 'Plan no encontrado.');
        }

        return new PlanResource($plan);
    }

    /**
     * @OA\Delete(
     * path="/api/v1/plans/{id}",
     * summary="Delete a plan",
     * tags={"Plans"},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=204, description="Plan deleted successfully"),
     * @OA\Response(response=404, description="Plan not found")
     * )
     */
    public function destroy(int $id): Response
    {
        $success = $this->deletePlanUseCase->execute($id);

        if (!$success) {
            abort(404, 'Plan no encontrado.');
        }

        return response()->noContent();
    }
}