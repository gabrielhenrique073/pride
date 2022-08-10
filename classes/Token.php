<?php

namespace Pride\Classes
{

    use Pride\Repositories\TokenRepository;
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    use Exception;

    final class Token
    {
        private $props = [];

        public function setClaim(string $label, $value) : void {
            $this -> props[$label] = $value;
        }

        public function generate() : string {
            $this -> setClaim('iat', time());
            $this -> setClaim('exp', time() + getenv('JWT_EXP'));

            $authorization = JWT::encode(
                $this -> props, 
                getenv('JWT_KEY'), 
                'HS256'
            );

            $tokenRepository = new TokenRepository();
            $tokenRepository -> store -> insert(
                [
                    'authorization' => $authorization,
                ]
            );

            return $authorization;
        }
        public function revoke(string $authorization) : void {

            if(!$this -> isValid($authorization))
                throw new Exception('You can not revoke an invalid authorization', 401);

            $tokenRepository = new TokenRepository();
            $tokenData = $tokenRepository -> store -> findOneBy(
                [
                    ['authorization', '=', $authorization]
                ]
            );
            $tokenRepository -> gateway -> updateById(
                $tokenData['id'],
                [
                    'isRevoked' => true
                ]
            );
        }
        public function isValid(string $authorization): bool {
            try{
                JWT::decode(
                    $authorization, 
                    new Key(getenv('JWT_KEY'), 'HS256')
                );
            } catch(Exception $e){
                return false;
            }

            $tokenRepository = new TokenRepository();
            $tokenData = $tokenRepository -> store -> findOneBy(
                [
                    ['authorization', '=', $authorization],
                    ['isRevoked', '=', true]
                ]
            );

            if($tokenData)
                return false;

            return true;
        }
    }
}