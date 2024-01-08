<?php

use pizzashop\auth\api\app\actions\SignUpAction;
use Slim\App;
use pizzashop\auth\api\app\actions\SignInAction;
use pizzashop\auth\api\app\actions\ValidateTokenAction;
use pizzashop\auth\api\app\actions\RefreshTokenAction;

return function(App $app) {
    $app->group('/api/users', function($group) {
        $group->post('/signin', SignInAction::class);
        $group->get('/validate', ValidateTokenAction::class);
        $group->post('/refresh', RefreshTokenAction::class);
        $group->post('/signup', SignUpAction::class);
    });
};