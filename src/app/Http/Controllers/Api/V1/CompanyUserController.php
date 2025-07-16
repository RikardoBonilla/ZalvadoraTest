<?php

namespace App\Http\Controllers\Api\V1;

use App\Application\User\Add\AddUserToCompanyDTO;
use App\Application\User\Add\AddUserToCompanyUseCase;
use App\Application\User\ListByCompany\ListUsersInCompanyUseCase;
use App\Domain\User\Exception\UserLimitExceededException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Infrastructure\Persistence\Eloquent\Models\CompanyModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CompanyUserController extends Controller
{
    public function __construct(
        private readonly AddUserToCompanyUseCase $addUserUseCase,
        private readonly ListUsersInCompanyUseCase $listUsersUseCase
    ) {}

    /**
     * Display a listing of the users for a specific company.
     */
    /**
     * @OA\Get(
     * path="/api/v1/companies/{company}/users",
     * summary="Listar usuarios de una empresa",
     * tags={"Users"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="company", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="OK")
     * )
     */
    public function index(CompanyModel $company): AnonymousResourceCollection
    {
        // Opcional: Podríamos añadir una política para ver usuarios también.
        // $this->authorize('viewUsers', $company);

        $users = $this->listUsersUseCase->execute($company->id);
        return UserResource::collection($users);
    }

    /**
     * Store a newly created user in storage for a specific company.
     */
    /**
     * @OA\Post(
     * path="/api/v1/companies/{company}/users",
     * summary="Añadir un nuevo usuario a una empresa",
     * tags={"Users"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="company", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreUserRequest")),
     * @OA\Response(response=201, description="Usuario creado"),
     * @OA\Response(response=422, description="Límite de usuarios excedido")
     * )
     */
    public function store(StoreUserRequest $request, CompanyModel $company): JsonResponse
    {
        // 1. Autorizar la acción usando la política que creamos
        $this->authorize('addUser', $company);

        try {
            // 2. Crear el DTO y ejecutar el caso de uso
            $dto = new AddUserToCompanyDTO(
                companyId: $company->id,
                name: $request->validated('name'),
                email: $request->validated('email'),
                password: $request->validated('password')
            );
            $user = $this->addUserUseCase->execute($dto);

            // 3. Devolver la respuesta de éxito
            return (new UserResource($user))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);

        } catch (UserLimitExceededException $e) {
            // 4. Capturar nuestra excepción personalizada y devolver un error claro
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422 Unprocessable Entity
        }
    }

    /**
     * @OA\Put(
     * path="/api/v1/companies/{company}/users/{user}",
     * summary="Actualizar un usuario específico",
     * tags={"Users"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="company", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Parameter(name="user", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateUserRequest")),
     * @OA\Response(response=200, description="Usuario actualizado")
     * )
     */
    public function update(UpdateUserRequest $request, CompanyModel $company, UserModel $user): UserResource
    {
        $this->authorize('update', $user); // Usamos una política de usuario

        $dto = new UpdateUserDTO(
            userId: $user->id,
            name: $request->validated('name'),
            email: $request->validated('email')
        );
        $updatedUser = $this->updateUserUseCase->execute($dto);

        return new UserResource($updatedUser);
    }

    /**
     * @OA\Delete(
     * path="/api/v1/companies/{company}/users/{user}",
     * summary="Borrar un usuario específico",
     * tags={"Users"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="company", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Parameter(name="user", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=204, description="Usuario eliminado")
     * )
     */
    public function destroy(CompanyModel $company, UserModel $user): Response
    {
        $this->authorize('delete', $user); // Usamos una política de usuario

        $this->deleteUserUseCase->execute($user->id);

        return response()->noContent();
    }
}
