<?php

declare(strict_types=1);

namespace Irlix\Docgen\Console;

use Illuminate\Console\Command;
use Irlix\Docgen\DocService;
use JsonException;
use ReflectionException;

class DocGenerate extends Command
{
    protected $signature = 'doc:generate';

    protected $description = 'Create an API documentation from routes';

    public function __construct(
        private readonly DocService $docService,
    )
    {
        parent::__construct();
    }

    /**
     * @throws JsonException
     * @throws ReflectionException
     */
    public function handle(): void
    {
        $this->docService->generate();
    }
}
