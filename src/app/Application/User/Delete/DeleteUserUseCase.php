<?php
    namespace App\Application\User\Delete;

    use App\Domain\User\UserRepositoryInterface;

    class DeleteUserUseCase {
        public function __construct(private readonly UserRepositoryInterface $userRepository) {}
        public function execute(int $id): bool {
            return $this->userRepository->delete($id);
        }
    }