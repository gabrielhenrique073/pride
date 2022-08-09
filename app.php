<?php

require './vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory as App;

use Pride\Routes\AuthRoute;

$app = App::create();

$app -> post('/auth', 
    function(Request $req, Response $res){

        $body = $req -> getParsedBody();

        if(!isset($body['username'])) throw new Exception('Username is required', 400);
        if(!isset($body['password'])) throw new Exception('Password is required', 400);

        $username = (string) $body['username'];
        $password = (string) $body['password'];

        $authRoute = new AuthRoute();
        $token = $authRoute -> signIn($username, $password);

        $res 
            -> getBody() 
            -> write(
                json_encode(
                    [
                        'token' => $token
                    ]
                )
            );

        return $res
            -> withHeader('content-type', 'application/json')
            -> withStatus(201);
    }
);

$app -> run();