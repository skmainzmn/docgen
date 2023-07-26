<?php

namespace Skmainzmn\Docgen\Types;

use Skmainzmn\Docgen\DocType;
use Skmainzmn\Docgen\Interfaces\HasLength;
use Exception;

class DocIntType extends DocType implements HasLength
{
    /**
     * @var string
     */
    protected string $jsonApiType = 'integer';

    /**
     * @return $this
     * @throws Exception
     */
    protected function randomValue(): self
    {
        $this->value = random_int($this->randomMinValue(), $this->randomMaxValue());

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
