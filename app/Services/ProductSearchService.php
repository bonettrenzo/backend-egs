<?php

namespace App\Services;

use Elasticsearch\ClientBuilder; 
use App\Interface\IProductSearchService;

class ProductSearchService implements IProductSearchService
{
    public function search(string $query)
    {
        $apiKey = config('services.elasticsearch.api_key');
        list($id, $key) = explode(':', base64_decode($apiKey));

        $client = ClientBuilder::create()
            ->setHosts([config('services.elasticsearch.host')])
            ->setApiKey($id, $key)
            ->build();

        $params = [
            'index' => 'products',
            'body'  => [
                'query' => [
                    'query_string' => [
                        'query'     => "*$query*",
                        'fields'    => ['nombre^500', 'descripcion^300', 'categoria^100'],
                        'fuzziness' => 'AUTO'
                        
                    ]
                ]
            ]
        ];

        return $client->search($params);
    }
    
}