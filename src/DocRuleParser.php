<?php

namespace Skmainzmn\Docgen;

class DocRuleParser
{
    public function __construct(private array $rules = []){}

    /**
     * @return array
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
