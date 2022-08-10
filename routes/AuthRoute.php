<?php

namespace Pride\Routes
{

    use Pride\Classes\Token;
    use Pride\Classes\User;
    use Pride\Classes\Account;
    use Pride\Classes\Auth;
    use Exception;

    final class AuthRoute
    {
        public function signIn(string $username, string $password) : string {

            $auth = new Auth();

            if(!$auth -> match($username, $password))
                throw new Exception('Invalid credentials', 400);

            $token = new Token();
            $token -> setClaim('sub', 1);
            $token -> setClaim('name', 'Gabriel Lopes');

            return $token -> generate();
        }
        public function signOut(string $authorization) : void {

            $token = new Token();

            if(!$token -> isValid($authorization))
                throw new Exception('Invalid token');

            $token -> revoke($authorization);
        }
    }
}