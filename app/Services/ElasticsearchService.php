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
}