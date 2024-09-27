<?php

declare(strict_types=1);

return [

    'storage' => [

        'disk' => env('DOCGEN_DISK', env('FILESYSTEM_DISK', 'local')),

        'filepath' => env('DOCGEN_FILEPATH', ''),

        'filename' => env('DOCGEN_FILENAME', 'api-docs'),
    ],

];
