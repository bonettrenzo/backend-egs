<?php

namespace App\Services;

use Elasticsearch\ClientBuilder; 
use App\Interface\IProductSearchService;

class ProductSearchService implements IProductSearchService
{
    public function search(string $query)
    {
        $client = ClientBuilder::create()
            ->setHosts([config('services.elasticsearch.host')])
            ->build();

        $params = [
            'index' => 'products',
            'body'  => [
                'query' => [
                    'query_string' => [
                        'query'     => "*$query*",
                        'fields'    => ['nombre^3', 'descripcion', 'categoria'],
                        'fuzziness' => 'AUTO'
                        
                    ]
                ]
            ]
        ];

        return $client->search($params);
    }
    
}