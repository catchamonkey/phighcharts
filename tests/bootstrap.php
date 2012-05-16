<?php

require_once '/home/sites/phighcharts/poc/UniversalClassLoader.php';
use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->register();

$loader->registerNamespaces(array(
    'Phighchart' => __DIR__.'/../classes'
));