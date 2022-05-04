<?php
namespace App\Test\TestCase\Action\Recipe;

use App\Action\Recipe\RecipeCreateAction;
use PHPUnit\Framework\TestCase;
use App\Test\Traits\AppTestTrait;

class RecipeCreateActionTest extends TestCase
{
    use AppTestTrait;

    public function testRecipeCreation_Correct_Result(): void
    {
       //Create recipe
        $request = $this->createJsonRequest('POST', '/recipe', [
            "Name" => "Brownie UnitTest",
            "RecipeTypeId" => 3,
            "TimeCook" => 20,
            "TimePrep" => 10,
            "Instructions" => "Custom instructions",
            "Ingredients" => "Custom ingredients"
        ]);

        // On effectue la requête et récupère le résultat
        $response = $this->app->handle($request);

        // J'affirme que les valeurs de retour correspondent à ce qui est attendu
        $this->assertSame(201, $response->getStatusCode());

        // J'affirme que les valeurs de retour correspondent à ce qui est attendu
        $this->assertSame((bool)json_decode((string)$response->getBody())->success, true);
    }
}
