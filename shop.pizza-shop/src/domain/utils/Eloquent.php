<?php

namespace pizzashop\shop\domain\utils;

use Illuminate\Database\Capsule\Manager as DB;

class Eloquent
{
    public static function init($filename) {
        $db = new DB();
        $db->addConnection(parse_ini_file($filename));
        $db->bootEloquent();
        $db->setAsGlobal();
    }
}