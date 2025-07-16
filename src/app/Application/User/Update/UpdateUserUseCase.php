<?php
    
    namespace App\Application\User\Update;
    
    use App\Domain\User\UserRepositoryInterface;

    class UpdateUserUseCase {
        public function __construct(private readonly UserRepositoryInterface $userRepository) {}
        public function execute(UpdateUserDTO $dto): ?\App\Domain\User\User {
            $user = $this->userRepository->findById($dto->userId);
            if (!$user) return null;
            $user->name = $dto->name;
            $user->email = $dto->email;
            return $this->userRepository->save($user);
        }
    }

