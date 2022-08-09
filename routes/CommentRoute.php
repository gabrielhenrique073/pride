<?php

namespace Pride\Routes
{

    use Exception;

    final class CommentRoute
    {
        public function comment(string $token, string $content, int $post) : bool {
            throw new Exception('Not implemented');
        }
        public function list(string $token, int $post) : array {
            throw new Exception('Not implemented');
        }
        public function get(string $token, int $id) : array {
            throw new Exception('Not implemented');
        }
    }
}