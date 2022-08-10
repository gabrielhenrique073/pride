<?php

namespace Pride\Routes
{
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Pride\Classes\Account;
    use Exception;

    final class AccountRoute
    {
        public static function register(Request $req, Response $res) : Response {
            
            $body = $req -> getParsedBody();

            if(!isset($body['username'])) throw new Exception('Username is required', 400);
            if(!isset($body['password'])) throw new Exception('Password is required', 400);

            $username = (string) $body['username'];
            $password = (string) $body['password'];

            $account = new Account();
            $account -> register($username, $password);

            return $res -> withStatus(201);
        }
    }
}