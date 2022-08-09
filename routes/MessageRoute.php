<?php

namespace Pride\Routes
{

    use Exception;

    final class MessageRoute
    {
        public function list(string $token, int $page) : array {
            throw new Exception('Not implemented');
        }
        public function send(string $token, string $content) : bool {
            throw new Exception('Not implemented');
        }
    }
}