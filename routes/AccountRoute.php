<?php

namespace Pride\Routes
{

    use Exception;

    final class AccountRoute
    {
        public function register(string $username, string $password) : bool {
            throw new Exception('Not implemented');
        }
        public function unregister(string $authorization) : bool {
            throw new Exception('Not implemented');
        }
    }
}