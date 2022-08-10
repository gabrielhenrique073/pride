<?php

namespace Pride\Routes
{

    use Exception;

    final class CommentRoute
    {
        public function comment(string $authorization, string $content, int $post) : bool {
            throw new Exception('Not implemented');
        }
        public function list(string $authorization, int $post) : array {
            throw new Exception('Not implemented');
        }
        public function get(string $authorization, int $id) : array {
            throw new Exception('Not implemented');
        }
    }
}