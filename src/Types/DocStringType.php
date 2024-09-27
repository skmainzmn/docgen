<?php

declare(strict_types=1);

namespace Irlix\Docgen\Types;

use Exception;
use Faker\Factory;
use Illuminate\Support\Str;
use Irlix\Docgen\Contracts\HasLength;

class DocStringType extends DocType implements HasLength
{
    public bool $isEmail = false;

    public function __construct(array $validationRules)
    {
        parent::__construct($validationRules);

        if (in_array('email', $validationRules, true)) {
            $this->isEmail = true;
        }
    }

    /**
     * @throws Exception
     */
    protected function randomValue(): self
    {
        $length = random_int($this->randomMinValue(), $this->randomMaxValue());

        if ($this->isEmail) {
            $this->value = Factory::create()->email;
        } elseif ($length > 5) {
            $this->value = fake()->text($length);
        } else {
            $this->value = Str::random($length);
        }

        return $this;
    }

    public function randomMinValue(): int
    {
        return $this->hasMin() ? $this->getMin() : 1;
    }

    public function randomMaxValue(): int
    {
        return $this->hasMax() ? $this->getMax() : 500;
    }
}
