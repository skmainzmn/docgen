<?php

namespace Skmainzmn\Docgen\Types;

use Skmainzmn\Docgen\DocType;

class DocDateType extends DocType
{
    /**
     * @return $this
     */
    protected function randomValue(): self
    {
        $this->value = fake()->date();

        return $this;
    }
}
