<?php

namespace App\Observers;

use App\Models\Product;
use Elasticsearch\ClientBuilder;

class ProductObserver
{
    protected $client;

    public function __construct() 
    {   
        $apiKey = config('services.elasticsearch.api_key');
        list($id, $key) = explode(':', base64_decode($apiKey));

        $this->client = ClientBuilder::create()
            ->setHosts([config('services.elasticsearch.host')])
            ->setApiKey($id, $key)
            ->build();
    }

    /**
     */
    public function created(Product $product): void
    {
        $this->client->index([
            'index' => 'products',
            'id'    => $product->id,
            'refresh' => true,
            'body'  => $product->toArray()
        ]);
    }

    /**
     */
    public function updated(Product $product): void
    {
        $this->client->index([
            'index' => 'products',
            'id'    => $product->id,
            'refresh' => true,
            'body'  => $product->toArray()
        ]);
    }

    /**
     */
    public function deleted(Product $product): void
    {
        try {
            $this->client->delete([
                'index' => 'products',
                'refresh' => true,
                'id'    => $product->id
            ]);
        } catch (\Exception $e) {
        }
    }
}