<?php

declare(strict_types=1);

use ElasticAdapter\Indices\Mapping;
use ElasticAdapter\Indices\Settings;
use ElasticMigrations\Facades\Index;
use ElasticMigrations\MigrationInterface;

final class CreateEcommerceIndex implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::create('ecommerce_index', function (Mapping $mapping, Settings $settings) {
            $settings->analysis([
                'filter' => [
                    'ngram_filter' => [
                        'type' => 'edge_ngram',
                        'min_gram' => 2,
                        'max_gram' => 10,
                        'token_chars' => [
                            'letter',
                            'digit',
                            'punctuation',
                            'symbol',
                        ],
                    ],
                ],
                'analyzer' => [
                    'ngram_analyzer' => [
                        'type' => 'custom',
                        'tokenizer' => 'whitespace',
                        'filter' => [
                            'lowercase',
                            'asciifolding',
                            'ngram_filter',
                        ],
                    ],
                    'whitespace_analyzer' => [
                        'type' => 'custom',
                        'tokenizer' => 'whitespace',
                        'filter' => [
                            'lowercase',
                            'asciifolding',
                        ],
                    ],
                ],
            ]);

            $mapping->text('completion_name');
            $mapping->integer('type');
            $mapping->searchAsYouType('completion_terms', [
                'analyzer' => 'ngram_analyzer',
                'search_analyzer' => 'whitespace_analyzer',
            ]);
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists('ecommerce_index');
    }
}
