<?php

declare(strict_types=1);

namespace Irlix\Docgen\Contracts;

interface HasLength
{
    public function randomMinValue(): int;
    public function randomMaxValue(): int;
}
