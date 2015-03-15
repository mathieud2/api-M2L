<?php

//chargement de l'autoloader composer pour charger les composants
require 'vendor/autoload.php';


use RedBean_Facade as r;

// création de la relation base de donnée
r::setup('mysql:host=localhost; dbname=', 'root', 'root');
r::freeze(true);


$app = new \Slim\Slim(array(
    'debug' => true
));

// exemple d'utilisation de slim
$app->get('/', function() use ($app) {

    // recupération des entité dans la base de donnée
    $exemples = r::findAll('Nom de la base');
    // je renvoie un header avec le type de fichier, la du json
    $app->response()->header('Content-type','application/json');
    // encodage des données en json
    echo json_encode(r::exportAll($exemples));

});

//lancement du serveur api
$app->run();