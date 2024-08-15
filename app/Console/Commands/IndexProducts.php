<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use App\Models\ProductKeyword;
use App\Services\ElasticsearchService;

class IndexProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index products into Elasticsearch';

    /**
     * Elasticsearch service
     *
     * @var ElasticsearchService
     */
    protected $elasticsearchService;

    /**
     * Create a new command instance.
     *
     * @param ElasticsearchService $elasticsearchService
     * @return void
     */
    public function __construct(ElasticsearchService $elasticsearchService)
    {
        parent::__construct();
        $this->elasticsearchService = $elasticsearchService;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // Get all products with their variations, features, keywords, category, and sub-category
            $products = ProductInventory::with(['variations', 'features', 'keywords', 'category', 'subCategory'])->get();

            // delete index if already exists
            $this->elasticsearchService->deleteIndex(['index' => 'products']);

            // Define the index settings and mappings
            $params = [
                'index' => 'products',
                'body' => [
                    'settings' => [
                        'number_of_shards' => 1,
                        'number_of_replicas' => 0,
                    ],
                    'mappings' => [
                        'properties' => [
                            'variations' => [
                                'properties' => [
                                    'title' => ['type' => 'text'],
                                    'title_suggest' => ['type' => 'completion'],
                                    'sku' => ['type' => 'keyword'],
                                    'sku_suggest' => ['type' => 'completion'],
                                    'description' => ['type' => 'text'],
                                    'description_suggest' => ['type' => 'completion'],
                                    'slug' => ['type' => 'keyword'],
                                    'hsn' => ['type' => 'keyword'],
                                    'hsn_suggest' => ['type' => 'completion'],
                                    'features' => ['type' => 'keyword'],
                                    'features_suggest' => ['type' => 'completion'],
                                    'keywords' => ['type' => 'keyword'],
                                    'keywords_suggest' => ['type' => 'completion'],
                                    'category' => ['type' => 'keyword'],
                                    'category_suggest' => ['type' => 'completion'],
                                    'category_slug' => ['type' => 'keyword'],
                                    'sub_category' => ['type' => 'keyword'],
                                    'sub_category_suggest' => ['type' => 'completion'],
                                ],
                            ]
                        ],
                    ],
                ],
            ];


        // Create the index with the mapping
        $this->elasticsearchService->createIndex($params);
            // Index each product
            foreach ($products as $product) {
                foreach ($product->variations as $variation) {
                    if ($variation->status == ProductInventory::STATUS_ACTIVE || $variation->status == ProductInventory::STATUS_OUT_OF_STOCK) {
                        $list = [
                            'title' => $variation->title,
                            'title_suggest' => [
                                'input' => $variation->title
                            ],
                            'sku'   => $variation->sku,
                            'sku_suggest' => [
                                'input' => $variation->sku
                            ],
                            'description' => $variation->description,
                            'description_suggest' => [
                                'input' => $variation->description
                            ],
                            'slug'  => $variation->slug,
                            'keywords'    => $product->keywords->pluck('keyword')->toArray(),
                            'category'    => $product->category->name,
                            'category_slug' => $product->category->slug,
                            'sub_category' => $product->subCategory->name,
                            'hsn'         => $product->hsn,
                            'hsn_suggest' => [
                                'input' => $product->hsn
                            ],
                            'features'    => $product->features->pluck('value')->toArray(),
                            'features_suggest' => [
                                'input' => $product->features->pluck('value')->toArray()
                            ],
                            'keywords_suggest' => [
                                'input' => $product->keywords->pluck('keyword')->toArray()
                            ],
                            'category_suggest' => [
                                'input' => $product->category->name
                            ],
                            'sub_category_suggest' => [
                                'input' => $product->subCategory->name
                            ],
                        ];
                        $parameter = [
                            'index' => 'products',
                            'id'    => $variation->id,
                            'body'  => [
                                'variations'  => $list
                            ],
                        ];
                        $this->elasticsearchService->index($parameter);
                    }else{
                        continue;
                    }
                }
                // Index the product First time

                // // Check if the product is already indexed
                // $existingProduct = $this->elasticsearchService->get(['index' => 'products', 'id' => $product->id]);
                // // If the product is not indexed, index it
                // if (!$existingProduct) {
                //     $this->elasticsearchService->index($params);
                // }

                // // add if any changes found in the product data update it
                // if ($existingProduct['_source'] != $params['body']) {
                //     $this->elasticsearchService->update($params);
                // }
            }


            $this->info('Products have been indexed.');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
