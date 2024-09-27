<?php

declare(strict_types=1);

namespace Irlix\Docgen;

use Irlix\Docgen\Types\DocArrayType;
use Irlix\Docgen\Types\DocBooleanType;
use Irlix\Docgen\Types\DocDateType;
use Irlix\Docgen\Types\DocIntType;
use Irlix\Docgen\Types\DocNumericType;
use Irlix\Docgen\Types\DocStringType;
use Irlix\Docgen\Types\DocType;

class DocTypeFactory
{
    public const array TYPES = [
        'numeric',
        'array',
        'boolean',
        'int',
        'integer',
        'string',
        'date',
    ];

    public static function init(array $rules): DocType
    {
        foreach ($rules as $rule) {
            if (!in_array($rule, static::TYPES, true)) {
                continue;
            }

            return match ($rule) {
                'string' => new DocStringType($rules),
                'integer', 'int' => new DocIntType($rules),
                'array' => new DocArrayType($rules),
                'numeric' => new DocNumericType($rules),
                'boolean' => new DocBooleanType($rules),
                'date' => new DocDateType($rules),
                default => new DocType($rules),
            };
        }

        return new DocType($rules);
    }
}
