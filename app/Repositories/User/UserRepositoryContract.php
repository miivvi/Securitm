<?php
declare(strict_types=1);

namespace App\Repositories\User;

use Illuminate\Support\Collection;

interface UserRepositoryContract
{
    public function findBy(?string $name): Collection;
}
