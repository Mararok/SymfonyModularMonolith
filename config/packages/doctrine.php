<?php

use App\Core\Doctrine\DoctrineModuleConfigsLoader;

$loader = new DoctrineModuleConfigsLoader($container, dirname(__DIR__)."/modules");
$loader->load();
