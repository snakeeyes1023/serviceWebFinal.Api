<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class HomeAction
{
    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        
        $result = json_encode([
            'success' => true, 
            'message' => 'Hello world!'
        ]);
        
        $response->getBody()->write($result);

        return $response->withHeader('Content-Type', 'application/json');
        
        /**
         * Changer le code de statut de la réponse
         * 
         * return $response
         *          ->withHeader('Content-Type', 'application/json')
         *          ->withStatus(422);
         * 
         */


        return $response;
    }
}
