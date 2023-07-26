<?php

namespace Skmainzmn\Docgen\Console\Commands;

use App\Docs\DocService;
use Illuminate\Console\Command;
use JsonException;
use ReflectionException;

class DocGenerate extends Command
{
    /**
     * @var string
     */
    protected $signature = 'doc:generate';

    /**
     * @var string
     */
    protected $description = 'Create an API documentation from routes';

    public function __construct(
        private readonly DocService $docService,
    )
    {
        parent::__construct();
    }

    /**
     * @return void
     * @throws JsonException
     * @throws ReflectionException
     */
    public function handle(): void
    {
        $this->docService->generate();
    }
}
