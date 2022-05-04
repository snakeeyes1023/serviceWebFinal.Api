<?php
namespace App\Test\TestCase\Action\RecipeType;

use PHPUnit\Framework\TestCase;
use App\Test\Traits\AppTestTrait;

class RecipeTypeFetchActionTest extends TestCase
{
    use AppTestTrait;

    public function testRecipeTypeFetch_Correct_Result(): void
    {
        
        //Create recipe
        $request = $this->createJsonRequest('GET', '/recipe-type');

        // On effectue la requête et récupère le résultat
        $response = $this->app->handle($request);

        $this->assertSame(200, $response->getStatusCode());

        // J'affirme que les valeurs de retour correspondent à ce qui est attendu
        $this->assertNotSame((int)json_decode((string)$response->getBody())->count, 0);
    }
}
