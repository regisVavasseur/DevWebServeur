<?php

namespace domain\provider;

use domain\entites\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use pizzashop\shop\domain\service\catalogue\AuthProviderCredentialsException;

class AuthProvider
{

    private User $currentAuthenticatedUserEntity;

    /**
     * @throws Exception
     */
    private function generateRefreshToken(User $user): void
    {
        $user->refresh_token = bin2hex(random_bytes(32));
        $user->refresh_token_expiration = date('Y-m-d H:i:s', time() + 3600);
        $user->save();
    }

    /**
     * @throws AuthProviderCredentialsException
     * @throws Exception
     */
    public function checkCredentials(string $username, string $password): void
    {
        try {
            $user = User::where('email', $username)->firstOrFail();

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

    public function getAuthenticatedUser(): array
    {
        return [
            'username' => $this->currentAuthenticatedUserEntity->userName,
            'email' => $this->currentAuthenticatedUserEntity->email,
            'refresh_token' => $this->currentAuthenticatedUserEntity->refresh_token,
        ];
    }
}