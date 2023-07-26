<?php

namespace App\Docs\Types;

use App\Docs\DocType;
use App\Docs\Interfaces\HasLength;

class DocNumericType extends DocType implements HasLength
{
    /**
     * @var string
     */
    protected string $jsonApiType = 'number';

    /**
     * @return $this
     */
    protected function randomValue(): self
    {
        $this->value = fake()->randomFloat(2, $this->randomMinValue(), $this->randomMaxValue());

        return $this;
    }

    /**
     * @return int
     */
    public function randomMinValue(): int
    {
        return $this->hasMin() ? $this->getMin() : -mt_getrandmax();
    }

    /**
     * @return int
     */
    public function randomMaxValue(): int
    {
        return $this->hasMax() ? $this->getMax() : mt_getrandmax();
    }
}
