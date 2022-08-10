<?php

namespace Pride\Repositories
{
    use SleekDB\Store;
    
    class Repository extends Store
    {
        public function __construct() {
            $this -> gateway = new Store(
                $this -> name, 
                ROOT . '/data',
                [
                    'auto_cache' => false,
                    'primary_key' => 'id'
                ]
            );
        }
    }
}