<?php

//chargement de l'autoloader composer pour charger les composants
require 'vendor/autoload.php';


use RedBean_Facade as r;

// création de la relation base de donnée
r::setup('mysql:host=localhost; dbname=formationMrbs', 'root', 'root');
r::freeze(true);


$app = new \Slim\Slim(array(
    'debug' => true
));

/**
 *  recupération de tous les exemples
 */
$app->get('/exemples', function() use ($app) {

    $exemples = r::findAll('Nom de la table');
    $app->response()->header('Content-type','application/json');
    echo json_encode(r::exportAll($exemples));

});

/**
 * recuperation d'un exemple avec un id particulier et renvoie de la reponse sous forme de json
 */
$app->get('/exemples/:id', function($id) use ($app) {

    try {
        $exemples = r::findOne('nom de la table', 'id = ?', array($id));
        if($exemples) {
            $app->response()->header('content-type', 'application/json');
            echo json_encode(r::exportAll($exemples));
        }

    } catch (Exception $e) {
        $app->response()->status(404);
        $app->response()->header('X-Status-Reason', $e->getMessage());
    };

});

/**
 * route de création d'un exemple
 */
$app->post('/exemples', function() use ($app) {

    try {
        $request = $app->request();
        $body    = $request->getBody();
        $input   = json_decode($body);

        $exemples = r::dispense('nom de la base');

        $exemples->titleExemple = $input->titleExemple;
        $id = r::store($exemples);

        $app->response()->header('content-type', 'application/json');
        echo json_encode(r::exportAll($exemples));

    } catch(Exception $e) {
        $app->response()->status('400');
        $app->response()->header('X-Status-Reason', $e->getMessage());
    }

});


$app->group('/formation', function() use ($app) {
    $app->get('/');
    $app->post('/');
    $app->put('/:id');
    $app->delete('/:id');
});

$app->group('/formateur', function() use ($app) {
    $app->get('/');
    $app->post('/');
    $app->put('/:id');
    $app->delete('/:id');
});

$app->group('/competences', function() use ($app) {
    $app->get('/');
    $app->post('/');
    $app->put('/:id');
    $app->delete('/:id');
});

$app->group('/ville', function() use ($app) {
    $app->get('/');
    $app->post('/');
    $app->put('/:id');
    $app->delete('/:id');
});

$app->group('/niveau', function() use ($app) {
    $app->get('/');
    $app->post('/');
    $app->put('/:id');
    $app->delete('/:id');
});

$app->group('/session', function() use ($app) {
    $app->get('/');
    $app->post('/');
    $app->put('/:id');
    $app->delete('/:id');
});


//lancement du serveur api
$app->run();