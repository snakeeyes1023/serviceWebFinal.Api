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
            "Id" => 0,
            "Name" => "Brownie UnitTest",
            "Type" => 3,
            "TimeCook" => 20,
            "TimePrep" => 10,
            "Instructions" => "Custom instructions",
            "Ingredients" => "Custom ingredients",
            "Note" => "My note",
            "Tags" => "My tags"
        ]);

        // On effectue la requête et récupère le résultat
        $response = $this->app->handle($request);

        $this->assertSame(201, $response->getStatusCode());
        var_dump($response);
        // J'affirme que les valeurs de retour correspondent à ce qui est attendu

        $this->assertNotSame((bool)$response["success"], false);
    }
}
