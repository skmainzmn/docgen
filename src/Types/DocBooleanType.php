<?php

namespace Skmainzmn\Docgen\Types;

use Skmainzmn\Docgen\DocType;

class DocBooleanType extends DocType
{
    protected function randomValue(): self
    {
        $this->value = (bool)random_int(0, 1);

        return $this;
    }
}
