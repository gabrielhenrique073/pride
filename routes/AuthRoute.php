<?php

namespace Pride\Routes
{

    use Exception;

    final class AuthRoute
    {
        public function signIn(string $username, string $password) : string {
            return 'Not implemented';
        }
        public function signOut(string $token) : bool {
            throw new Exception('Not implemented');
        }
    }
}