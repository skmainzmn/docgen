<?php

namespace App\Docs\Types;

use App\Docs\DocType;

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
