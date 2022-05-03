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
       //Create recipe
        $request = $this->createJsonRequest('DELETE', '/recipe/36');

        // On effectue la requête et récupère le résultat
        $response = $this->app->handle($request);

        $this->assertSame(200, $response->getStatusCode());
        var_dump($response);
        // J'affirme que les valeurs de retour correspondent à ce qui est attendu

        $this->assertNotSame((bool)$response["success"], false);
    }
}
