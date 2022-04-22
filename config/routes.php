<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Middleware\BasicAuthMiddleware;
use App\Middleware\AuthorizeTokenMiddleware;
use Slim\App;

return function (App $app) {

    $app->get('/user/{id}', \App\Action\UserActions\UserAction::class);

    $app->get('/recipes', \App\Action\Recipe\RecipeFetchAction::class);
    
    $app->get('/cle_api', \App\Action\UserActions\UserApiTokenAction::class);

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);
};

