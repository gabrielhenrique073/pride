<?php

namespace Pride\Routes
{
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Pride\Classes\Auth;
    use Exception;

    final class AuthRoute
    {
        public static function signIn(Request $req, Response $res) : Response {

            $body = $req -> getParsedBody();

            if(!isset($body['username'])) throw new Exception('Username is required', 400);
            if(!isset($body['password'])) throw new Exception('Password is required', 400);

            $username = (string) $body['username'];
            $password = (string) $body['password'];

            $auth = new Auth();
            $authorization = $auth -> signIn($username, $password);

            $res
                -> getBody()
                -> write($authorization);

            return $res -> withStatus(201);
        }
    }
}