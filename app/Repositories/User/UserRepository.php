<?php
declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\AbstractEloquentRepository;
use Illuminate\Support\Collection;

class UserRepository extends AbstractEloquentRepository implements UserRepositoryContract
{
    public function findBy(?string $name): Collection
    {
        $query = $this->query(['sort']);

        if ($name) {
            $query->where('name', 'like', "%{$name}%");
        }

        return $query->get();
    }

    /**
     * @return string
     */
    protected function modelClass(): string
    {
        return User::class;
    }
}
