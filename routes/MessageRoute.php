<?php

namespace Pride\Routes
{

    use Exception;

    final class MessageRoute
    {
        public function list(string $authorization, int $page) : array {
            throw new Exception('Not implemented');
        }
        public function send(string $authorization, string $content) : bool {
            throw new Exception('Not implemented');
        }
    }
}