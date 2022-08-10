<?php

namespace Pride\Routes
{

    use Exception;

    final class PostRoute
    {
        public function publicate(string $authorization, string $content) : bool {
            throw new Exception('Not implemented');
        }
        public function list(string $authorization, int $page) : array {
            throw new Exception('Not implemented');
        }
        public function get(string $authorization, int $id) : array {
            throw new Exception('Not implemented');
        }
    }
}