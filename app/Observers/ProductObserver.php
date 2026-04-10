<?php

namespace App\Observers;

use App\Models\Product;
use Elasticsearch\ClientBuilder;

class ProductObserver
{
    protected $client;

    public function __construct() 
    {
        $this->client = ClientBuilder::create()
            ->setHosts([config('services.elasticsearch.host')])
            ->build();
    }

    /**
     */
    public function created(Product $product): void
    {
        $this->client->index([
            'index' => 'products',
            'id'    => $product->id,
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
                'id'    => $product->id
            ]);
        } catch (\Exception $e) {
        }
    }
}