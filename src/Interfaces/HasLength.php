<?php

namespace App\Docs\Interfaces;

interface HasLength
{
    public function randomMinValue(): int;
    public function randomMaxValue(): int;
}
