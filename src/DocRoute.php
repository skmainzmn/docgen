<?php

declare(strict_types=1);

namespace Irlix\Docgen;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionException;
use ReflectionMethod;

class DocRoute
{
    public const array DYNAMIC_PROPS = [
        'tags',
        'description',
        'operationId',
        'summary',
        'requestBody',
        'parameters',
    ];

    private string $uri;
    private string $method;
    private string $description = '';
    private string $summary;
    private array $tags = [];
    private string $operationId;
    private array $requestBody = [];
    private array $parameters = [];
    private array $responseBody = [];

    /**
     * @throws ReflectionException
     */
    public function __construct(private readonly Route $route)
    {
        $this->uri = $route->uri();
        $this->method = Str::lower(Arr::first($route->methods()));

        [$controller, $method] = explode('@', $route->getActionName());

        $entity = Str::replace('Controller', '', Arr::last(explode('\\', $controller)));

        $this->tags[] = ucfirst(str_replace('_', ' ', Str::snake($entity)));

        $this->operationId = Str::lower($entity.'.'.$method);

        $this->summary = str_replace('_', ' ', Str::snake($method));

        $this->addParameters();
        $this->handleRequestBody();
    }

    public function handle(): array
    {
        $result = [];

        foreach (static::DYNAMIC_PROPS as $property) {
            if ($this->$property) {
                $result[$property] = $this->$property;
            }
        }

        return [
            $this->method => [
                ...$result,
                'responses' => [
                    '200' => [
                        'description' => 'success',
                        ...$this->responseBody,
                    ]
                ],
                'security'  => [
                    [
                        'bearer_token' => [],
                    ]
                ],
            ]
        ];
    }

    private function addParameters(): void
    {
        foreach ($this->route->parameterNames() as $parameter) {
            $this->parameters[] = [
                'name'        => $parameter,
                'in'          => 'path',
                'description' => "id of $parameter",
                'required'    => true,
                'schema'      => [
                    'type' => 'integer'
                ]
            ];
        }
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function handleRequestBody(): void
    {
        [$controller, $method] = explode('@', $this->route->getActionName());
        $reflectionMethod = new ReflectionMethod($controller, $method);

        foreach ($reflectionMethod->getParameters() as $parameter) {
            if (!$parameter->getType()?->isBuiltin()) {
                /** @var FormRequest $formRequest */
                $formRequest = new ($parameter->getType()?->getName());

                if (!($formRequest instanceof FormRequest)) {
                    continue;
                }

                $this->requestBody = $this->generateJsonSchema(
                    (new DocRuleParser($formRequest->rules()))->getProperties(),
                );
            }
        }
    }

    protected function generateJsonSchema(array $value = [], bool $isObject = false): array
    {
        return [
            'content' => [
                'application/json' => [
                    'schema' => [
                        ...($isObject ? ['type' => 'object'] : []),
                        'properties' => $value,
                    ]
                ],
            ],
        ];
    }
}
