<?php

declare(strict_types=1);

namespace Irlix\Docgen;

use Exception;

readonly class DocRuleParser
{
    public function __construct(private array $rules = []){}

    /**
     * @throws Exception
     */
    public function getProperties(): array
    {
        $properties = [];

        foreach ($this->rules as $property => $rules) {
            $docType = DocTypeFactory::init($rules);

            $properties[$property] = [
                'type' => $docType->getType(),
                'nullable' => $docType->isNullable(),
                'example' => $docType->generate(),
            ];
        }

        return $properties;
    }
}
