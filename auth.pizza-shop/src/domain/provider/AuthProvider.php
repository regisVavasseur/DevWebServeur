<?php

namespace domain\provider;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\shop\domain\service\catalogue\AuthProviderCredentialsException;
use function PHPUnit\Framework\isEmpty;

class AuthProvider
{

    private function generateRefreshToken(User $user): void
    {
        $user->refresh_token = bin2hex(random_bytes(32));
        $user->refresh_token_expiration = date('Y-m-d H:i:s', time() + 3600);
        $user->save();


    }

    public function checkCredentials(string $username, string $password): void
    {
        try {
            $user = User::where('username', $username)->firstOrFail();

        } catch (ModelNotFoundException $e) {
            throw new AuthProviderCredentialsException("User not found");
        }

        if (!password_verify($password, $user->password)) {
            throw new AuthProviderCredentialsException("Wrong password");
        } else {
            $this->generateRefreshToken($user);
            $this->currentAuthenticatedUserEntity = $user;

        }


    }

    public function checkToken(string $token): void
    {

    }

    public function register(string $username, string $password): void
    {

    }

    public function activate(string $token): void
    {

    }

    public function resetPassword(string $token, string $old_password, string $new_password): void
    {

    }

    public function getAuthenticatedUser(): array {}
}