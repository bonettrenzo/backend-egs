<?php

namespace App\Services;

use Elasticsearch\ClientBuilder; 

class ProductSearchService 
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
                    'multi_match' => [
                        'query'     => $query,
                        'fields'    => ['nombre^3', 'descripcion', 'categoria'],
                        'fuzziness' => 'AUTO'
                        
                    ]
                ]
            ]
        ];

        return $client->search($params);
    }
}