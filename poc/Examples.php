<?php

require_once '/home/sites/phighcharts/poc/UniversalClassLoader.php';
use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->register();

$loader->registerNamespaces(array(
    'Phighchart'    => __DIR__.'/../classes'
));

use Phighchart\Chart;
use Phighchart\Options\Container as OptionsContainer;
use Phighchart\Options\ExtendedContainer as ExtendedOptionsContainer;
use Phighchart\Data;
use Phighchart\Renderer\Pie;
use Phighchart\Renderer\Line;

$extOptions = new ExtendedOptionsContainer();
$extOptions->setStickyColour('apples', '#629632');
$extOptions->setStickyColour('oranges', '#CD3700');

$options = new OptionsContainer('chart');
$options->setRenderTo('chart_example_59');
$options->setMarginRight(130);
$options->setMarginBottom(25);

$titleOptions = new OptionsContainer('title');
$titleOptions->setText('Monthly Details');
$titleOptions->setX(-20);

$data = new Data();
$data
    ->addCount('Apples', 32)
    ->addCount('Oranges', 68)
    ->addSeries('Apples', array(
        '2012-05-01' => 12,
        '2012-05-02' => 3,
        '2012-05-03' => 33
    ))
    ->addSeries('Oranges', array(
        '2012-05-01' => 32,
        '2012-05-02' => 36,
        '2012-05-03' => 18
    ));

// put it all together
$chart  = new Chart();
$chart
    ->addOptions($options)
    ->addOptions($titleOptions)
    ->addOptions($extOptions)
    ->setData($data)
    ->setRenderer(new Pie());

// a line chart is similiar, and our data container holds series data for this
$lineChart = clone $chart;
$options = new OptionsContainer('chart');
$options->setRenderTo('chart_example_60');
$options->setMarginRight(130);
$options->setMarginBottom(25);
$lineChart->addOptions($options)->setRenderer(new Line());
