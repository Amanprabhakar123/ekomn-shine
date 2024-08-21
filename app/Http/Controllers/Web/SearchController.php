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

    /**
     * Search for products
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
                            'field' => 'variations.keywords_suggest',
                            'size'  => 5
                        ]
                    ],
                    'category_suggest' => [
                        'prefix'    => $query, // Your search term here
                        'completion' => [
                            'field' => 'variations.category_suggest',
                            'size'  => 5
                        ]
                    ],
                    'sub_category_suggest' => [
                        'prefix'    => $query, // Your search term here
                        'completion' => [
                            'field' => 'variations.sub_category_suggest',
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
                            'field' => 'variations.hsn_suggest',
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
                            'field' => 'variations.features_suggest',
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
                                return ['url' => route('product.category', $item['_source']['variations']['category_slug']), 'text' => $item['_source']['variations']['title'] .' - ( '.$item['text'].' )']; 
                            }elseif($key === 'sub_category_suggest'){
                                return ['url' => route('product.category', $item['_source']['variations']['category_slug']), 'text' => $item['_source']['variations']['title'] .' - ( '.$item['text'].' )'];
                            }elseif($key === 'sku_suggest'){
                                return ['url' => route('product.details', $item['_source']['variations']['slug']), 'text' => $item['_source']['variations']['title'] .' ( '.$item['text'].' )'];
                            }elseif($key === 'hsn_suggest'){
                                return ['url' => route('product.details', $item['_source']['variations']['slug']), 'text' => $item['_source']['variations']['title'] .' ( '.$item['text'].' )'];
                            }else{
                                return ['url' => route('product.details', $item['_source']['variations']['slug']), 'text' =>  $item['_source']['variations']['title']];
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

    /**
     * Search for keywords
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByKeyWord(Request $request)
    {
        $query = $request->input('query');

        $indexParams = [
            'index' => 'keywords',
            'body'  => [
                'suggest' => [
                    'keywords_suggest' => [
                        'prefix'    => $query, // Your search term here
                        'completion' => [
                            'field' => 'keyword_suggest',
                            'size'  => 10
                        ]
                    ],
                    'title_suggest' => [
                        'prefix'    => $query, // Your search term here
                        'completion' => [
                            'field' => 'title_suggest',
                            'size'  => 10
                        ]
                    ],
                    'sku_suggest' => [
                        'prefix'    => $query, // Your search term here
                        'completion' => [
                            'field' => 'sku_suggest',
                            'size'  => 10
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
                    'keywords_suggest',
                    'title_suggest',
                    'sku_suggest'
                ];
                
                // Extract suggestions for each key
                foreach ($suggestionKeys as $key) {
                    // Check if the suggestion exists and extract text from each suggestion
                    if (isset($results['suggest'][$key][0]['options'])) {
                        $suggestions[] = array_map(function ($item) use ($key) {
                            if ($key == 'keywords_suggest') {
                                return ['url' => url('/').'/search?q=keyword&term=' . $item['_source']['keyword'], 'text' =>  $item['text']];
                            }elseif($key == 'title_suggest'){
                                return ['url' => url('/').'/search?q=title&term=' . $item['text'], 'text' =>  $item['_source']['title']];
                            }else{
                                return ['url' => url('/').'/search?q=keyword&term=' . $item['_source']['sku'], 'text' =>  $item['text']];
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function displayProductSearch()
    {
        // Retrieve the full query string from the URL
        $fullQueryString = request()->getQueryString();

        // Parse the query string into an associative array
        parse_str($fullQueryString, $queryArray);

        $type = $queryArray['q'];
        // Extract the specific term value (e.g., term2pcs)
        $query = $queryArray['term'] ?? 'default_value'; // Use 'default_value' if 'term2pcs' is not set
        
        return view('web.product-search', compact('query', 'type'));
    }
}
