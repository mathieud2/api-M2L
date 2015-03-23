<?php
require 'vendor/autoload.php';
require 'controllers/formationCtrl.php';

use RedBean_Facade as r;


r::setup('mysql:host=localhost; dbname=mydb', 'root', 'root');
r::freeze(true);

$app = new \Slim\Slim(array(
    'debug' => true
));



$app->get('/formation','\controllers\formationCtrl:findAllFormation');
$app->get('/formation/:id', '\controllers\formationCtrl:findOneFormation');
$app->post('/formation','\controllers\formationCtrl:createFormation');


$app->run();