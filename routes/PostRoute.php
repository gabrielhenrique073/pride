<?php

namespace Pride\Routes
{

    use Exception;

    final class PostRoute
    {
        public function publicate(string $token, string $content) : bool {
            throw new Exception('Not implemented');
        }
        public function list(string $token, int $page) : array {
            throw new Exception('Not implemented');
        }
        public function get(string $token, int $id) : array {
            throw new Exception('Not implemented');
        }
    }
}