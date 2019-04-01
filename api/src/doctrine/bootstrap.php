<?php
require __DIR__ . '/../../vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array('Entidades');
$isDevMode = true;

$dbParams = array(
   'dbname' => 'desafio',
   'user' => 'root',
   'password' => 'sL@root159',
   'host' => '127.0.0.1',
   'driver' => 'pdo_mysql',
);

//setando as configurações definidas anteriormente
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);

//criando o Entity Manager com base nas configurações de dev e banco de dados
$em = EntityManager::create($dbParams, $config);