<?php

namespace Pride\Classes
{

    use Exception;

    final class Auth
    {
        public function match(string $username, string $password) : bool {
            return true;
        }
    }
}