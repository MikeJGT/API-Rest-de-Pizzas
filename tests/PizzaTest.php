<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\PizzaFactory;
use App\Story\PizzaStory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class PizzaTest extends ApiTestCase
{  
    // use ResetDatabase, Factories;
    
    public function testGetCollection(): void
    {
        // PizzaFactory::createMany(100);
        static::createClient()->request('GET', '/api/pizzas?page=1'
        // ['headers' => [
        //     'Accept' => 'application/ld+json']
        // ]
    );
        $this->assertResponseIsSuccessful(message:'The response failed');
       
        $this->assertResponseHeaderSame('content-type','application/ld+json; charset=utf-8',
        message:'The content-type is not the same');

        $this->assertJsonContains([
        '@context' => '/api/contexts/Pizza',
        '@id' => '/api/pizzas',
        '@type' => 'hydra:Collection',
        'hydra:totalItems' => 100,
        'hydra:view' => [
            '@id' => '/api/pizzas?page=1',
            '@type' => 'hydra:PartialCollectionView',
            'hydra:first' => '/api/pizzas?page=1',
            'hydra:last' => '/api/pizzas?page=20',
            'hydra:next' => '/api/pizzas?page=2',
        ],
        'hydra:search'=> [
            '@type' => 'hydra:IriTemplate',
            'hydra:template' => '/api/pizzas{?name}',
            'hydra:variableRepresentation' => 'BasicRepresentation',
            'hydra:mapping' => [
                [
                '@type' => 'IriTemplateMapping',
                'variable' => 'name',
                'property' => 'name',
                'required' => false
                ]
            ]
        ]
    ]);
    }

    public function testCreatePizza(){
       static::createClient()->request('PATCH', '/api/pizzas/1',
    //    ['headers' => [
    //     'Accept' => 'application/ld+json']
    // ],
    //    ,
    // ['headers' => [
    //     'Accept' => 'application/ld+json',
    //     'CONTENT_TYPE' => 'application/ld+json']],
        ['json' => [
            'name' => 'Carbonara',
            'ingredients' => [
                'Cream',
                'Bacon',
                'Queso',
                'Champs'
            ],
            'ovenTimeInSeconds' => 10000,
            'special' => true
        ]]
    );

        $this->assertResponseIsSuccessful(message:'The response failed');
        // $this->assertResponseStatusCodeSame(201, message:'The status code is not 201.');
        // $this->assertResponseHeaderSame('content-type','application/ld+json',
        // message:'The content-type is not the same');

        // $this->assertJsonContains([
        //     '@context' => '/api/contexts/Pizza',
        //     '@id' => '/api/pizzas',
        //     '@type' => 'hydra:Collection',
        //     'name' => 'Carbonara',
        //     'ingredients' => [
        //         'Cream',
        //         'Bacon',
        //         'Queso',
        //         'Champs'
        //     ],
        //     'ovenTimeInSeconds' => 10000,
        //     'special' => true
        // ]);
    }

    // public function testCreatedInvalidPizza(){
    //     static::createClient()->request('POST', '/api/pizzas',
    //     ['headers' => [
    //     'Accept' => 'application/ld+json',
    //     'CONTENT_TYPE' => 'application/ld+json']   
    // ],
    //     ['json' => [
    //         'name' => '+48Chars->12345678901234567890123456789012345678901234567890',
    //         'ingredients' => [
    //             'Cream',
    //             'Bacon',
    //             'Queso',
    //             'Champs',
    //             'Onion',
    //             'Cream',
    //             'Bacon',
    //             'Queso',
    //             'Champs',
    //             'Onion',
    //             'Cream',
    //             'Bacon',
    //             'Queso',
    //             'Champs',
    //             'Onion',
    //             'Cream',
    //             'Bacon',
    //             'Queso',
    //             'Champs',
    //             'Onion',
    //             'Cream',
    //             'Bacon',
    //             '+20 Ingredients'
    //         ],
    //         'special'=>true
    //     ]]);
 
    //     $this->assertResponseIsSuccessful(message:'The response failed');
    //     $this->assertResponseStatusCodeSame(422, message:'The status code should be 422');
    //     $this->assertResponseHeaderSame('content-type','application/ld+json; charset=utf-8',
    //     message:'The content-type is not the same');
 
    //     $this->assertJsonContains([
    //     "@type"=> "ConstraintViolationList",
    //     "status" => 422,
    //     "violations" => [
    //         [
    //         "propertyPath" => "name",
    //         "message" => "This value is too long. It should have 48 characters or less."
    //         ],
    //         [
    //         "propertyPath" => "ingredients",
    //         "message" => "You cannot specify more than 20 ingredients"
    //         ]
    //     ],
    //     "detail" => "name: This value is too long. It should have 48 characters or less.\ningredients: You cannot specify more than 20 ingredients",
    //     "hydra:title" => "An error occurred",
    //     "hydra:description" => "name: This value is too long. It should have 48 characters or less.\ningredients: You cannot specify more than 20 ingredients"
            
    //     ]);
    //  }
}
