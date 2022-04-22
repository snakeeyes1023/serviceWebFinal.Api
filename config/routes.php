<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Middleware\BasicAuthMiddleware;
use App\Middleware\AuthorizeTokenMiddleware;
use Slim\App;

return function (App $app) {


    $app->get('/recipes', \App\Action\Recipe\RecipeFetchAction::class);
    
    $app->post('/recipe', \App\Action\Recipe\RecipeCreateAction::class);

    $app->put('/recipe', \App\Action\Recipe\RecipeUpdateAction::class);

    $app->delete('/recipe', \App\Action\Recipe\RecipeDeleteAction::class);

    $app->get('/cle_api', \App\Action\UserActions\UserApiTokenAction::class);

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);
};

