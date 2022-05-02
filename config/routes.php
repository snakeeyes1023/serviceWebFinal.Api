<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Middleware\BasicAuthMiddleware;
use App\Middleware\AuthorizeTokenMiddleware;
use Slim\App;

return function (App $app) {


    //RECIPES

    $app->get('/recipes', \App\Action\Recipe\RecipeFetchAction::class);
    
    $app->post('/recipe', \App\Action\Recipe\RecipeCreateAction::class);

    $app->post('/recipe/{id}', \App\Action\Recipe\RecipeUpdateAction::class);

    $app->delete('/recipe/{id}', \App\Action\Recipe\RecipeDeleteAction::class);


    //RECIPE TYPE
    $app->get('/recipe-type', \App\Action\RecipeType\RecipeTypeFetchAction::class);

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);

    $app->options('/{routes:.*}', \App\Action\PreflightAction::class);
};

