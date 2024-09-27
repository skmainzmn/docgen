<?php

declare(strict_types=1);

namespace Irlix\Docgen;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use JsonException;
use ReflectionException;

class DocService
{
    /**
     * @throws JsonException
     * @throws ReflectionException
     */
    public function generate(): void
    {
        $list = [];

        foreach (Route::getRoutes() as $route) {
            if (!in_array('api', $route->middleware(), true)) {
                continue;
            }

            $docRoute = new DocRoute($route);
            $uri = $route->uri();

            $list["/$uri"] = [
                ...($list["/$uri"] ?? []),
                ...$docRoute->handle(),
            ];
        }

        Storage
            ::disk($this->getStorageDisk())
            ->put(
                $this->getFilePath(),
                json_encode([
                    'openapi' => '3.0.0',
                    'info' => [
                        'title' => config('app.name') . ' Документация',
                        'version' => '1.0',
                    ],
                    'paths' => $list,
                    'components' => [
                        'securitySchemes' => [
                            'bearer_token' => [
                                'type' => 'apiKey',
                                'description' => 'Enter token in format (Bearer <token>)',
                                'name' => 'Authorization',
                                'in' => 'header',
                            ],
                        ],
                    ],
                    ],
                    JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ),
            );
    }

    private function getStorageDisk(): string
    {
        return config('docgen.storage.disk');
    }

    private function getFilePath(): string
    {
        return config('docgen.storage.filepath') . config('docgen.storage.filename') . '.json';
    }
}
