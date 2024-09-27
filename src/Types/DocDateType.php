<?php

declare(strict_types=1);

namespace Irlix\Docgen\Types;

class DocDateType extends DocType
{
    protected function randomValue(): self
    {
        $this->value = fake()->date();

        return $this;
    }
}
