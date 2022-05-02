<?php
// Source : https://www.slimframework.com/docs/v4/concepts/middleware.html
namespace App\Middleware;

use App\Domain\User\Service\UserService;
use App\Factory\LoggerFactory;
use PhpParser\Node\Expr\Empty_;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Handlers\Strategies\RequestHandler;
use Slim\Psr7\Request;
use Slim\Psr7\Response;


class AuthorizeTokenMiddleware
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler): \Psr\Http\Message\ResponseInterface
    {
        // Extraction du token encodé de l'entête
        $token = $request->getHeaderLine('Authorization');
        $token = trim($token);
    
        if (Empty($token) || !$this->userService->isTokenValid($token)) {
        
            //Return status unauthorized to response
            $response = new Response();
            
            $response->getBody()->write((string)json_encode(['error' => 'Unauthorized']));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
            
        }
    
        // Sinon on retourne la réponse originale
        return $handler->handle($request);
    }
}