<?php

namespace controllers;

use RedBean_Facade as r;
use Slim\Slim;

/**
 * Controller de gestion des formations
 *
 * Class formationCtrl
 * @package controllers
 */
class formationCtrl
{
    /**
     * récupération de toute les formation en un seul coup
     */
    public function findAllFormation()
    {
        $formations = r::findAll('formation');
        Slim::getInstance()->response()->header('content-type', 'application/json');
        echo json_encode(r::exportAll($formations));
    }

    /**
     * recupération d'une formation grace a son id
     *
     * @param string $id
     */
    public function findOneFormation($id)
    {
        try {
            $formation = r::findOne('formation','id = ?', array($id));

            if ($formation) {
                Slim::getInstance()->response()->header('content-type', 'application/json');
                echo json_encode(r::exportAll($formation));
            } else {
                throw new \Exception;
            }
        } catch (\Exception $e) {
            Slim::getInstance()->response()->status(404);
            Slim::getInstance()->response()->header('X-Status-Reason', $e->getMessage());
        }
    }

    /**
     * création d'une formation par import Json
     */
    public function createFormation()
    {
        try {
            $request = Slim::getInstance()->request();
            $body    = $request->getBody();
            $input = json_decode($body);

            $formation = r::dispense('formation');
            $formation->nom = $input[0]->nom;
            $id = r::store($formation);

            Slim::getInstance()->response()->header('content-type', 'application/json');
            echo json_encode(r::exportAll($formation));

        } catch (\Exception $e) {
            Slim::getInstance()->response()->status(400);
            Slim::getInstance()->response()->header('X-Status-Reason', $e->getMessage());
        }
    }

}