<?php

namespace Pride\Classes
{
    use Pride\Classes\Account;
    use Exception;

    final class Auth
    {
        public function signIn(string $username, string $password) : string {

            $account = new Account();
            
            if(!$account -> isCredentialsRight($username, $password))
                throw new Exception('Invalid credentials', 400);

            $accountData = $account -> getByUsername($username);

            $token = new Token();
            $token -> setClaim(
                'sub', 
                $accountData['id']
            );

            return $token -> generate();
        }
        public function signOut(string $token) : void {

        }
    }
}