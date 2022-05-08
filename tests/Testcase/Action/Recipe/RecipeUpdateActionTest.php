<?php
namespace App\Test\TestCase\Action\Recipe;

use App\Action\Recipe\RecipeUpdateAction;
use PHPUnit\Framework\TestCase;
use App\Test\Traits\AppTestTrait;

class RecipeUpdateActionTest extends TestCase
{
    use AppTestTrait;

    public function testRecipeUpdate_Correct_Result(): void
    {
        
       //Update recipe
        $request = $this->createJsonRequest('PUT', '/recipe/36', [
            "Name" => "Brownie UnitTest",
            "RecipeTypeId" => 3,
            "TimeCook" => 20,
            "TimePrep" => 10,
            "Instructions" => "Custom instructions",
            "Ingredients" => "Custom ingredients"
        ]);

        // On effectue la requête et récupère le résultat
        $response = $this->app->handle($request);

        $this->assertSame(200, $response->getStatusCode());

        // J'affirme que les valeurs de retour correspondent à ce qui est attendu        
        $this->assertTrue((bool)json_decode((string)$response->getBody())->success);
    }
}
