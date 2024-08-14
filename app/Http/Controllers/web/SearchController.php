<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ElasticsearchService;

class SearchController extends Controller
{
    protected $elasticsearchService;

    public function __construct(ElasticsearchService $elasticsearchService)
    {
        $this->elasticsearchService = $elasticsearchService;
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $indexParams = [
            'index' => 'products',
            'body'  => [
                'suggest' => [
                    'title_suggest' => [
                        'prefix'    => $query, // Your search term here
                        'completion' => [
                            'field' => 'variations.title_suggest',
                            'size'  => 5
                        ]
                    ],
                    'keywords_suggest' => [
                        'prefix'    => $query, // Your search term here
                        'completion' => [
                            'field' => 'keywords_suggest',
                            'size'  => 5
                        ]
                    ],
                    'category_suggest' => [
                        'prefix'    => $query, // Your search term here
                        'completion' => [
                            'field' => 'category_suggest',
                            'size'  => 5
                        ]
                    ],
                    'sub_category_suggest' => [
                        'prefix'    => $query, // Your search term here
                        'completion' => [
                            'field' => 'sub_category_suggest',
                            'size'  => 5
                        ]
                    ],
                    'sku_suggest' => [
                        'prefix'    => $query, // Your search term here
                        'completion' => [
                            'field' => 'variations.sku_suggest',
                            'size'  => 5
                        ]
                    ],
                    'hsn_suggest' => [
                        'prefix'    => $query, // Your search term here
                        'completion' => [
                            'field' => 'hsn_suggest',
                            'size'  => 5
                        ]
                    ],
                    'description_suggest' => [
                        'prefix'    => $query, // Your search term here
                        'completion' => [
                            'field' => 'variations.description_suggest',
                            'size'  => 5
                        ]
                    ],
                    'features_suggest' => [
                        'prefix'    => $query, // Your search term here
                        'completion' => [
                            'field' => 'features_suggest',
                            'size'  => 5
                        ]
                    ]

                ]
            ]
        ];


        try {
            // Execute the search and extract suggestions
                $results = $this->elasticsearchService->search($indexParams);

                // Initialize an array to hold all suggestions
                $suggestions = [];

                // List of suggestion keys to process
                $suggestionKeys = [
                    'title_suggest',
                    'category_suggest',
                    'sub_category_suggest',
                    'keywords_suggest',
                    'sku_suggest',
                    'hsn_suggest',
                    'description_suggest',
                    'features_suggest'
                ];

                
                // Extract suggestions for each key
                foreach ($suggestionKeys as $key) {
                    // Check if the suggestion exists and extract text from each suggestion
                    if (isset($results['suggest'][$key][0]['options'])) {
                        $suggestions[] = array_map(function ($item) use ($key) {
                            if ($key === 'category_suggest') {
                                return ['url' => route('product.category', $item['_source']['category_slug']), 'text' => $item['text']]; 
                            }else{
                                return ['url' => route('product.details', $item['_source']['variations'][0]['slug']), 'text' => $item['text']];
                            }
                        }, $results['suggest'][$key][0]['options']);
                    }
                }
                // Flatten the array of arrays into a single array
                $suggestions = array_merge(...$suggestions);

            return response()->json($suggestions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
