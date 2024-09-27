<?php

declare(strict_types=1);

namespace Irlix\Docgen\Types;

use Illuminate\Support\Str;
use Irlix\Docgen\Contracts\HasLength;

class DocArrayType extends DocType implements HasLength
{
    protected function randomValue(): self
    {
        $this->value = array_fill_keys($this->getRandomKeys(), null);

        return $this;
    }

    protected function getRandomKeys(): array
    {
        $keys = [];

        for ($i = 0; $i <= random_int($this->randomMinValue(), $this->randomMaxValue()); $i++) {
            $keys[] = Str::random();
        }

        return $keys;
    }

    public function randomMinValue(): int
    {
        return $this->hasMin() ? $this->getMin() : 0;
    }

    public function randomMaxValue(): int
    {
        return $this->hasMax() ? $this->getMax() : 10;
    }
}
