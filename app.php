<?php

define('ROOT', __DIR__);

error_reporting(E_ALL);
ini_set('display_errors', '1');

require './vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy as Proxy;
use Slim\Factory\AppFactory as App;
use Pride\Routes\AuthRoute;

$app = App::create();

$app -> addRoutingMiddleware();

$errorMiddleware = $app -> addErrorMiddleware(true, true, true);
$errorMiddleware -> setDefaultErrorHandler(
    function(
        Request $req,
        Throwable $e,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails,
        ?LoggerInterface $logger = null
    ) use ($app) {

        $errorCode = $e -> getCode();
        if($errorCode < 100 || $errorCode > 599)
            $errorCode = 500;

        $res = $app 
            -> getResponseFactory() 
            -> createResponse();
    
        $res 
            -> getBody()
            -> write(
                json_encode(
                    [
                        'message' => $e -> getMessage(),
                    ]
                )
            );
    
        return $res
            -> withHeader('content-type', 'application/json')
            -> withStatus($errorCode);
    }
);

$app -> group('/auth', 
    function(Proxy $proxy){
        $proxy -> delete('', 
            function(Request $req, Response $res){
                $headers = $req -> getHeaders();

                if(!isset($headers['authorization'][0])) throw new Exception('Authorization is required', 401);

                $authorization = (string) $headers['authorization'][0];
                $authorization = preg_replace('/^(.*)\s/', '', $authorization);

                $authRoute = new AuthRoute();
                $authRoute -> signOut($authorization);

                return $res -> withStatus(200);
            }
        );
        $proxy -> post('', 
            function(Request $req, Response $res){
                $body = $req -> getParsedBody();

                if(!isset($body['username'])) throw new Exception('Username is required', 400);
                if(!isset($body['password'])) throw new Exception('Password is required', 400);

                $username = (string) $body['username'];
                $password = (string) $body['password'];

                $authRoute = new AuthRoute();
                $authorization = $authRoute -> signIn($username, $password);
                
                $res 
                    -> getBody() 
                    -> write($authorization);

                return $res -> withStatus(201);
            }
        );
    }
);

$app -> run();