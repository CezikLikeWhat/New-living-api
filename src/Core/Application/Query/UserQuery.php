<?php

declare(strict_types=1);

namespace App\Core\Application\Query;

use App\Core\Application\Query\UserQuery\Device;
use App\Core\Application\Query\UserQuery\UserInformations;
use App\Core\Domain\Uuid;

interface UserQuery
{
    public function getAllUserInformationsByUserId(Uuid $id): UserInformations;

    /**
     * @return Device[]
     */
    public function getAllUserDevicesByUserId(Uuid $id): array;
}
