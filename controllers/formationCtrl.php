<?php

namespace controllers;

use RedBean_Facade as r;
use Slim\Slim;

class formationCtrl
{
    public function findAllFormation()
    {
        $formations = r::findAll('formation');
        Slim::getInstance()->response()->header('content-type', 'application/json');
        echo json_encode(r::exportAll($formations));
    }
}