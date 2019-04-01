<?php
require_once("bootstrap.php");

$driver	= new \Doctrine\ORM\Mapping\Driver\DatabaseDriver($em->getConnection()->getSchemaManager());
$driver->setNamespace('Entidades\\');
$em->getConfiguration()->setMetadataDriverImpl($driver);

$cmf = new \Doctrine\ORM\Tools\DisconnectedClassMetadataFactory();
$cmf->setEntityManager($em);
$metadata = $cmf->getAllMetadata();

$etg = new \Doctrine\ORM\Tools\EntityGenerator;
$etg->setGenerateAnnotations(true);
$etg->setGenerateStubMethods(true);
$etg->setRegenerateEntityIfExists(true);
$etg->setUpdateEntityIfExists(true);

$result = $etg->generate($metadata,  __DIR__);
echo "Resultado: ";
print_r($result);
echo "\n";

exit;