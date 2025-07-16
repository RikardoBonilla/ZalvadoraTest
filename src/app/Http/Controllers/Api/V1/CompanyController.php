<?php

namespace App\Http\Controllers\Api\V1;

use App\Application\Company\ChangePlan\ChangeCompanyPlanDTO;
use App\Application\Company\ChangePlan\ChangeCompanyPlanUseCase;
use App\Application\Company\Delete\DeleteCompanyUseCase;
use App\Application\Company\List\ListCompaniesUseCase;
use App\Application\Company\Register\RegisterCompanyDTO;
use App\Application\Company\Register\RegisterCompanyUseCase;
use App\Application\Company\Update\UpdateCompanyDTO;
use App\Application\Company\Update\UpdateCompanyUseCase;
use App\Domain\Company\CompanyRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeCompanyPlanRequest;
use App\Http\Requests\RegisterCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function __construct(
        private readonly RegisterCompanyUseCase $registerCompanyUseCase,
        private readonly ListCompaniesUseCase $listCompaniesUseCase,
        private readonly UpdateCompanyUseCase $updateCompanyUseCase,
        private readonly DeleteCompanyUseCase $deleteCompanyUseCase,
        private readonly ChangeCompanyPlanUseCase $changeCompanyPlanUseCase,
        private readonly CompanyRepositoryInterface $companyRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    /** @OA\Get(path="/api/v1/companies", summary="Listar todas las empresas", tags={"Companies"}, @OA\Response(response=200, description="OK")) */
    public function index(): AnonymousResourceCollection
    {
        return CompanyResource::collection($this->listCompaniesUseCase->execute());
    }

    /**
     * Store a newly created resource in storage.
     */
    /** @OA\Post(path="/api/v1/companies", summary="Registrar una nueva empresa", tags={"Companies"}, @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/RegisterCompanyRequest")), @OA\Response(response=201, description="Creado")) */
    public function store(RegisterCompanyRequest $request): JsonResponse
    {
        $dto = new RegisterCompanyDTO(
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('plan_id')
        );
        $company = $this->registerCompanyUseCase->execute($dto);

        return (new CompanyResource($company))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    /** @OA\Get(path="/api/v1/companies/{id}", summary="Obtener una empresa por ID", tags={"Companies"}, @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="OK"), @OA\Response(response=404, description="No encontrado")) */
    public function show(int $id): CompanyResource
    {
        $company = $this->companyRepository->findById($id);
        if (!$company) {
            abort(404, 'Empresa no encontrada.');
        }
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     */
     /** @OA\Put(path="/api/v1/companies/{id}", summary="Actualizar una empresa", tags={"Companies"}, @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateCompanyRequest")), @OA\Response(response=200, description="OK")) */
    public function update(UpdateCompanyRequest $request, int $id): CompanyResource
    {
        // Asegúrate de que tu UpdateCompanyRequest también valide el 'email'
        $dto = new UpdateCompanyDTO(
            $id,
            $request->validated('name'),
            $request->validated('email')
        );
        $company = $this->updateCompanyUseCase->execute($dto);

        if (!$company) {
            abort(404, 'Empresa no encontrada.');
        }
        return new CompanyResource($company);
    }

    /**
     * Remove the specified resource from storage.
     */
    /** @OA\Delete(path="/api/v1/companies/{id}", summary="Borrar una empresa", tags={"Companies"}, @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=204, description="Sin contenido")) */
    public function destroy(int $id): Response
    {
        if (!$this->deleteCompanyUseCase->execute($id)) {
            abort(404, 'Empresa no encontrada.');
        }
        return response()->noContent();
    }

    /**
     * Custom action to change a company's subscription plan.
     */
    /** @OA\Post(path="/api/v1/companies/{company}/change-plan", summary="Cambiar el plan de una empresa", tags={"Companies"}, @OA\Parameter(name="company", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/ChangeCompanyPlanRequest")), @OA\Response(response=204, description="Sin contenido")) */
    public function changePlan(ChangeCompanyPlanRequest $request, int $company): Response
    {
        $dto = new ChangeCompanyPlanDTO(
            $company,
            $request->validated('new_plan_id')
        );
        $this->changeCompanyPlanUseCase->execute($dto);
        
        return response()->noContent();
    }
}