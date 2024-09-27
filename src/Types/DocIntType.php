<?php

declare(strict_types=1);

namespace Irlix\Docgen\Types;

use Exception;
use Irlix\Docgen\Contracts\HasLength;

class DocIntType extends DocType implements HasLength
{
    protected string $jsonApiType = 'integer';

    /**
     * @throws Exception
     */
    protected function randomValue(): self
    {
        $this->value = random_int($this->randomMinValue(), $this->randomMaxValue());

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
