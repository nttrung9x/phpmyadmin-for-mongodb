<?php
/*
    Defines a namespace for the model.
*/
namespace App\Models;

use MongoDB\Model\DatabaseInfo;

class Database extends DatabaseInfo
{
    public function getInfo()
    {
        return $this->__debugInfo();
    }
}
