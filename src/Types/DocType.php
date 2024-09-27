<?php

declare(strict_types=1);

namespace Irlix\Docgen\Types;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class DocType
{
    protected string $jsonApiType = 'string';

    protected bool $nullable = false;
    protected ?int $max = null;
    protected ?int $min = null;
    protected ?string $exists = null;
    protected ?array $inArray = null;

    protected mixed $value;

    public function __construct(array $validationRules)
    {
        foreach ($validationRules as $rule) {
            if (is_object($rule)) {
                continue;
            }

            if ($rule === 'nullable') {
                $this->nullable = true;
            }

            if (str_starts_with($rule, 'max:')) {
                $this->max = (int)explode(':', $rule)[1];
            }

            if (str_starts_with($rule, 'min:')) {
                $this->min = (int)explode(':', $rule)[1];
            }

            if (str_starts_with($rule, 'exists:')) {
                $this->exists = explode(':', $rule)[1];
            }

            if (str_starts_with($rule, 'in:')) {
                $this->inArray = explode(',', explode(':', $rule)[1]);
            }
        }
    }

    public function getType(): string
    {
        return $this->jsonApiType;
    }

    /**
     * @throws Exception
     */
    public function generate(bool $withNull = false): mixed
    {
        if ($this->hasExists()) {
            return $this->getExistsValue();
        }

        if ($this->hasInArray()) {
            return $this->getInArrayValue();
        }

        return $this->randomValue()->applyNullable($withNull)->getValue();
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }

    public function hasMax(): bool
    {
        return !is_null($this->max);
    }

    public function hasMin(): bool
    {
        return !is_null($this->min);
    }

    public function hasExists(): bool
    {
        return !is_null($this->exists);
    }

    public function hasInArray(): bool
    {
        return !is_null($this->inArray);
    }

    public function getExistsValue()
    {
        $params = explode(',', $this->exists);

        return DB::table($params[0])->value($params[1]);
    }

    public function getInArrayValue()
    {
        return Arr::random($this->inArray);
    }

    public function getMax(): int
    {
        return $this->max;
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @throws Exception
     */
    public function applyNullable(bool $withNullable = true): self
    {
        if ($withNullable && $this->isNullable() && random_int(0, 1)) {
            $this->value = null;
        }

        return $this;
    }

    protected function randomValue(): self
    {
        $this->value = mt_rand();

        return $this;
    }
}
