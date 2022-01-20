<?php

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;

class OpenApiFactory implements OpenApiFactoryInterface
{
    public function __construct(private OpenApiFactoryInterface $decorated)
    {
        
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
       
        /** @var PathItem $path */
        // foreach ($openApi->getPaths()->getPaths() as $key => $path){
        //     if ($path->getGet() && $path->getGet()->getSummary() === 'hidden') {
        //         $openApi->getPaths()->addPath($key, $path->withGet(null));
        //     }
        // }
        $schemas = $openApi->getComponents()->getSchemas();
        $schemas['Credentials'] = new \ArrayObject([
			'type' => 'object',
			'properties' => [
				'username' => [
					'type' => 'string',
					'example' => 'monUsername'
				],
				'password' => [
					'type' => 'string',
					'example' => 'password'
				]
			]
		]);

        $schemas['Token'] = new \ArrayObject([
			'type' => 'object',
			'properties' => [
				'token' => [
					'type' => 'string',
					'readOnly' => true
				],
				// 'refresh_token' => [
				// 	'type' => 'string',
				// 	'readOnly' => true
				// ]
			]
		]);
        $pathItem = new PathItem(
			post: new Operation(
				operationId: 'postApiLogin',
				tags: ['Authentication'],
				responses: [
					'200' => [
						'description' => 'JWT Token',
						'content' => [
							'application/json' => [
								'schema' => [
									'$ref' => '#/components/schemas/Token'
								]
							]
						]
					]
				],
				requestBody: new RequestBody(
					content: new \ArrayObject([
						'application/json' => [
							'schema' => [
								'$ref' => '#/components/schemas/Credentials'
							]
						]
					])
				)
			)
		);
        $openApi->getPaths()->addPath('/api/login', $pathItem);

        // $pathItem = new PathItem(
		// 	post: new Operation(
		// 		operationId: 'postApiLogout',
		// 		tags: ['Authentication'],
		// 		responses: [
		// 			'204' => []
		// 		]
		// 	)
		// );
		// $openApi->getPaths()->addPath('/api/logout', $pathItem);
        // $openApi->getPaths()->addPath('/ping', new PathItem(null, 'Ping', null, new Operation('ping-id', [], [], 'Repond')));
        return $openApi;

    }
}