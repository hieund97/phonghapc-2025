<?php

return [
    'table' => env('ELASTIC_MIGRATIONS_TABLE', 'elastic_migrations'),
    'storage_directory' => env('ELASTIC_MIGRATIONS_DIRECTORY', database_path('migrations/elastic'))
];
