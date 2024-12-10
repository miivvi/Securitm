<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

final class Sort implements Rule
{
    /**
     * @var array
     */
    private array $sortable;

    /**
     * Sort constructor.
     *
     * @param array $sortable
     */
    public function __construct(array $sortable)
    {
        $this->sortable = $sortable;
    }

    /**
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($this->getValue($value) as $field) {
            if (!in_array($field, $this->sortable) && !in_array("-{$field}", $this->sortable)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array|string
     */
    public function message()
    {
        return 'Available sort fields: {{fields}}.|fields=' . implode(', ', $this->sortable);
    }

    /**
     * @param mixed $value
     *
     * @return array
     */
    private function getValue($value): array
    {
        $sortable = explode(',', $value);
        foreach ($sortable as &$filed) {
            if (Str::startsWith($filed, '-')) {
                $filed = Str::replaceFirst('-', '', $filed);
            }
        }

        return $sortable;
    }
}
