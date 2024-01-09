<?php

namespace pizzashop\shop\domain\utils;

use Illuminate\Database\Capsule\Manager as DB;

class Eloquent
{
    private $db;

    //constructor
    public function __construct() {
        $this->db = new DB();
    }


    public function init($filename, $connectionName) {
        $this->db->addConnection(parse_ini_file($filename), $connectionName);
        $this->db->bootEloquent();
        $this->db->setAsGlobal();
    }
}