<?php
    namespace App\Application\User\Update;
    
    class UpdateUserDTO {
        public function __construct(
            public readonly int $userId,
            public readonly string $name,
            public readonly string $email
        ) {}
    }