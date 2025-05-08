<?php

declare(strict_types=1);

use ElasticAdapter\Indices\Mapping;
use ElasticAdapter\Indices\Settings;
use ElasticMigrations\Facades\Index;
use ElasticMigrations\MigrationInterface;

final class CreateProductsIndex implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::create('products_index', function (Mapping $mapping, Settings $settings) {
            $settings->index([
                'number_of_shards' => 1,
                'number_of_replicas' => 0,
            ]);

            $settings->analysis([
                'analyzer' => [
                    'autocomplete_analyzer' => [
                        'type' => 'custom',
                        'tokenizer' => 'autocomplete',
                        'filter' => ['asciifolding', 'lowercase'],
                    ],
                    'autocomplete_search_analyzer' => [
                        'type' => 'custom',
                        'tokenizer' => 'keyword',
                        'filter' => ['asciifolding', 'lowercase'],
                    ],
                ],
                'tokenizer' => [
                    'autocomplete' => [
                        'type' => 'edge_ngram',
                        'min_gram' => 1,
                        'max_gram' => 30,
                        'token_chars' => [
                            'letter',
                            'digit',
                            'whitespace',
                        ],
                    ],
                ],
            ]);

            $globalOptions = [
                'analyzer' => 'standard',
                'search_analyzer' => 'standard',
                'fields' => [
                    'keyword' => [
                        'type' => 'keyword',
                        'ignore_above' => 256,
                    ],
                ],
            ];

            $mapping->integer('id');
            $mapping->text('name', $globalOptions);
            $mapping->keyword('suggest_tags');
            $mapping->text('suggest_name', $globalOptions);
            $mapping->integer('sale_price');
            $mapping->date('sale_from');
            $mapping->date('sale_to');
            $mapping->text('serial');
            $mapping->text('brand_name');
            $mapping->integer('status');
            $mapping->text('product_category_name', $globalOptions);
            $mapping->text('parent_name', $globalOptions);
            $mapping->float('rate_star');
            $mapping->integer('rate_count');
            $mapping->text('accessory_names', $globalOptions);
            $mapping->text('suggest_keyword', [
                'fields' => [
                    'complete' => [
                        'type' => 'text',
                        'analyzer' => 'autocomplete_analyzer',
                        'search_analyzer' => 'autocomplete_search_analyzer',
                    ],
                ],
            ]);
            $mapping->integer('suggest_length');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists('products_index');
    }
}
