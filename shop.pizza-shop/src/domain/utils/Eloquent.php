<?php

namespace pizzashop\shop\domain\utils;

use Illuminate\Database\Capsule\Manager as DB;

class Eloquent
{
    public static function init($filename, $connectionName) {
        $db = new DB();
        $db->addConnection(parse_ini_file($filename), $connectionName);
        $db->bootEloquent();
        $db->setAsGlobal();
    }
}