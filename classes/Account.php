<?php

namespace Pride\Classes
{
    use Pride\Repositories\AccountRepository;
    use Exception;

    final class Account
    {
        public function isCredentialsRight(string $username, string $password) : bool {
            $accountRepository = new AccountRepository();

            // Get account data by username
            $accountData = $accountRepository -> store -> findOneBy(
                [
                    ['username', '=', $username],
                ]
            );

            // Check if user exists
            if(!$accountData)
                return false;

            // Check if password is right
            $isPasswordRight = password_verify(
                $password, 
                $accountData['password']
            );
            if(!$isPasswordRight)
                return false;

            // Return
            return true;
        }
        public function register(string $username, string $password) : void {
            $accountRepository = new AccountRepository();
            
            // Check if username is already in use
            $isRegistered = $accountRepository -> store -> findOneBy(
                [
                    ['username', '=', $username]
                ]
            );

            if($isRegistered)
                throw new Exception('Username already in use', 401);

            // Make the hash of password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert into store
            $accountRepository -> store -> insert(
                [
                    'username' => $username,
                    'password' => $hashedPassword
                ]
            );
        }
        public function getByUsername(string $username) : array {
            $accountRepository = new AccountRepository();
            return $accountRepository -> store -> findOneBy(
                [
                    ['username', '=', $username]
                ]
            );
        }
    }
}