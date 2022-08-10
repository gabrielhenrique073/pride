<?php

define('ROOT', __DIR__);

error_reporting(E_ALL);
ini_set('display_errors', '1');

require './vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy as Proxy;
use Slim\Factory\AppFactory as App;

$app = App::create();

$app -> addRoutingMiddleware();
$errorMiddleware = $app -> addErrorMiddleware(true, true, true);
$errorMiddleware -> setDefaultErrorHandler(function(Request $req, Throwable $e, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails, ?LoggerInterface $logger = null) use ($app) : Response {
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

$app -> group('', function(Proxy $root){
        $root -> group('/api', function(Proxy $api){
                $api -> group('/account', function(Proxy $account){
                        $account -> post('', 'Pride\Routes\AccountRoute::register');
                    }
                );
                $api -> group('/auth', function(Proxy $account){
                        $account -> post('', 'Pride\Routes\AuthRoute::signIn');
                    }
                );
            }
        );
    }
);


//                 $headers = $req -> getHeaders();

//                 if(!isset($headers['authorization'][0])) throw new Exception('Authorization is required', 401);

//                 $authorization = (string) $headers['authorization'][0];
//                 $authorization = preg_replace('/^(.*)\s/', '', $authorization);

$app -> run();