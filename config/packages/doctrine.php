<?php

use App\Core\Doctrine\ModularDoctrineConfigLoader;

$loader = new ModularDoctrineConfigLoader($container, dirname(__DIR__)."/modules");
$loader->load();
