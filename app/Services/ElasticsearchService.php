<?php

namespace App\Services;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchService
{
    protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(config('elasticsearch.hosts'))
            ->setSSLVerification(false) // Only use this for development
            ->setBasicAuthentication(env('ELASTICSEARCH_USER'), env('ELASTICSEARCH_PASSWORD'))
            ->build();
    }

    /**
     * Index a document
     *
     * @param array $params
     * @return array
     */
    public function index($params)
    {
        return $this->client->index($params);
    }

    /**
     * Search for documents
     *
     * @param array $params
     * @return array
     */
    public function search($params)
    {
        return $this->client->search($params);
    }

    /**
     * Get a document
     *
     * @param array $params
     * @return array
     */
    public function get($params)
    {
        return $this->client->get($params);
    }

    /**
     * Update a document
     *
     * @param array $params
     * @return array
     */
    public function update($params)
    {
        return $this->client->update($params);
    }

    /**
     * Delete a document
     *
     * @param array $params
     * @return array
     */
    public function delete($params)
    {
        return $this->client->delete($params);
    }

    /**
     * Delete an index
     *
     * @param array $params
     * @return array
     */
    public function deleteIndex($params)
    {
        return $this->client->indices()->delete($params);
    }

    /**
     * Create an index
     *
     * @param array $params
     * @return array
     */
    public function createIndex($params)
    {
        return $this->client->indices()->create($params);
    }

    /**
     * Search for a keyword
     *
     * @param string $title
     * @return array
     */
    public function searchKeyword($title)
    {
        $title = strtolower(trim($title));
        // Prepare the search parameters
        $searchParams = [
            'index' => 'keywords',
            'body'  => [
                'query' => [
                    'bool' => [
                        'should' => [
                            [
                                'term' => [
                                    'keyword' => $title
                                ]
                            ],
                            [
                                'term' => [
                                    'title' => $title
                                ]
                            ]
                        ],
                        'minimum_should_match' => 1 // Ensures at least one condition must match
                    ]
                ]
            ]
        ];

        return $this->client->search($searchParams);
    }
}
