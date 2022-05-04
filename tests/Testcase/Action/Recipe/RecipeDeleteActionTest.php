<?php
namespace App\Test\TestCase\Action\Recipe;

use App\Action\Recipe\RecipeDeleteAction;
use PHPUnit\Framework\TestCase;
use App\Test\Traits\AppTestTrait;

class RecipeDeleteActionTest extends TestCase
{
    use AppTestTrait;

    public function testRecipeDelete_Correct_Result(): void
    {
        // Delete recipe append authorization header
        $request = $this->createJsonRequest('DELETE', '/recipe/36')
        ->withHeader('Authorization', 'cd3d856e-ea00-4136-8e05-8c8decb31166');

        // On effectue la requête et récupère le résultat
        $response = $this->app->handle($request);

        // J'affirme que les valeurs de retour correspondent à ce qui est attendu
        $this->assertSame(200, $response->getStatusCode());
        
        // J'affirme que les valeurs de retour correspondent à ce qui est attendu
        $this->assertSame((bool)json_decode((string)$response->getBody())->success, true);
    }
}
