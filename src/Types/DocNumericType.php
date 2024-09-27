<?php

declare(strict_types=1);

namespace Irlix\Docgen\Types;

use Irlix\Docgen\Contracts\HasLength;

class DocNumericType extends DocType implements HasLength
{
    protected string $jsonApiType = 'number';

    protected function randomValue(): self
    {
        $this->value = fake()->randomFloat(2, $this->randomMinValue(), $this->randomMaxValue());

        return $this;
    }

    public function randomMinValue(): int
    {
        return $this->hasMin() ? $this->getMin() : -mt_getrandmax();
    }

    public function randomMaxValue(): int
    {
        return $this->hasMax() ? $this->getMax() : mt_getrandmax();
    }
}
