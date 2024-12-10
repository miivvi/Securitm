<?php

namespace App\Services\Request\Validation;

use App\Rules\Sort;

trait HasSort
{
    /**
     * @param mixed ...$sortable
     *
     * @return array
     */
    protected function sortRule(...$sortable): array
    {
        return [
            'sort' => ['sometimes', new Sort($sortable)],
        ];
    }
}
