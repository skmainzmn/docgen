<?php

namespace App\Docs;

use App\Docs\Types\DocArrayType;
use App\Docs\Types\DocBooleanType;
use App\Docs\Types\DocDateType;
use App\Docs\Types\DocIntType;
use App\Docs\Types\DocNumericType;
use App\Docs\Types\DocStringType;

class DocTypeFactory
{
    /**
     * @var array|string[]
     */
    public const TYPES = [
        'numeric',
        'array',
        'boolean',
        'int',
        'integer',
        'string',
        'date',
    ];

    /**
     * @param array $rules
     * @return DocType
     */
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
