<?php
namespace App\Test\TestCase\Action\Recipe;

use App\Action\Recipe\RecipeFetchAction;
use PHPUnit\Framework\TestCase;
use App\Test\Traits\AppTestTrait;

class RecipeFetchActionTest extends TestCase
{
    use AppTestTrait;

    public function testRecipeFetch_Correct_Result(): void
    {
       //Create recipe
        $request = $this->createJsonRequest('GET', '/recipes');

        // On effectue la requête et récupère le résultat
        $response = $this->app->handle($request);

        $this->assertSame(200, $response->getStatusCode());
        var_dump($response);
        // J'affirme que les valeurs de retour correspondent à ce qui est attendu

        $this->assertNotSame((int)$response["count"], 0);
    }
}
