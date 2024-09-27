<?php

declare(strict_types=1);

namespace Irlix\Docgen\Types;

class DocBooleanType extends DocType
{
    protected function randomValue(): self
    {
        $this->value = (bool)random_int(0, 1);

        return $this;
    }
}
