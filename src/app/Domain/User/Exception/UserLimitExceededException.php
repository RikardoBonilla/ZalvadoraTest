<?php

namespace App\Domain\User\Exception;

use Exception;

class UserLimitExceededException extends Exception
{
    // Podemos dejarla vacía, solo nos sirve para identificar el tipo de error.
}