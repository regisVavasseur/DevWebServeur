<?php

namespace pizzashop\auth\api\domain\entites;

use Illuminate\Database\Eloquent\Model;
use pizzashop\auth\api\domain\dto\UserDTO;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'email',
        'password',
        'active',
        'activation_token',
        'activation_token_expiration_date',
        'refresh_token',
        'refresh_token_expiration_date',
        'reset_passwd_token',
        'reset_passwd_token_expiration_date',
        'username'
    ];
    protected $hidden = [
        'password',
        'activation_token',
        'refresh_token',
        'reset_passwd_token'
    ];

    protected $primaryKey = 'email';
    public $incrementing = false;

    public $timestamps = false;

    public function toDTO () {
        $attributs = [
            'email' => $this->email,
            'password' => $this->password
        ];
        $userDTO = new UserDTO($attributs);
        return $userDTO;
    }
}