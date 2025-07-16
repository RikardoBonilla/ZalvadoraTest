<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Application\Plan\Create\CreatePlanUseCase;
use App\Application\Plan\Create\CreatePlanDTO;
use App\Application\Company\Register\RegisterCompanyUseCase;
use App\Application\Company\Register\RegisterCompanyDTO;
use App\Application\User\Add\AddUserToCompanyUseCase;
use App\Application\User\Add\AddUserToCompanyDTO;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Invocamos los casos de uso directamente
        $planUC = app(CreatePlanUseCase::class);
        $companyUC = app(RegisterCompanyUseCase::class);
        $userUC = app(AddUserToCompanyUseCase::class);

        // 1. Crear Planes
        $planBasico = $planUC->execute(new CreatePlanDTO('Básico', 20, 5, ['feat1']));
        $planPro = $planUC->execute(new CreatePlanDTO('Pro', 100, 50, ['feat2']));

        // 2. Crear una Empresa en el plan básico
        $empresa = $companyUC->execute(new RegisterCompanyDTO('Empresa de Prueba', 'admin@prueba.com', $planBasico->id));

        // 3. Crear un Usuario para esa empresa
        $userUC->execute(new AddUserToCompanyDTO($empresa->id, 'Usuario Admin', 'admin@prueba.com', 'password'));
    }
}