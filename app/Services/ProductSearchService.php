<?php

namespace App\Services;

use Elasticsearch\ClientBuilder; 

class ProductSearchService 
{
    public function search(string $query) 
    {
        // Ahora sí, esta clase será reconocida
        $client = ClientBuilder::create()
            ->setHosts([config('services.elasticsearch.host')])
            ->build();

        $params = [
            'index' => 'products',
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query'     => $query,
                        'fields'    => ['nombre^3', 'descripcion'],
                        'fuzziness' => 'AUTO'
                    ]
                ]
            ]
        ];

        return $client->search($params);
    }
}