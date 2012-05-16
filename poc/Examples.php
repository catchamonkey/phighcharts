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
use Phighchart\Options\ExtendedContainer;
use Phighchart\Data;
use Phighchart\Renderer\Pie;

$options = new OptionsContainer('chart');
$options->setRenderTo('chart_example_59');
$options->setMarginRight(130);
$options->setMarginBottom(25);

$extOptions = new ExtendedContainer();
$extOptions->setStickyColour('seo', '#e52d87');
$extOptions->setStickyColour('ppc', '#3c3c3c');

$titleOptions = new OptionsContainer('title');
$titleOptions->setText('Monthly Details');
$titleOptions->setX(-20);

$data       = new Data();
$data->addCount('SEO', 20);
$data->addCount('PPC', 60);
$data->addCount('seo', 20);

// or for a series chart (line/spline etc)
// $seoDataSeries  = new Data();
// $seoDataSeries  = array(
//    '2010-01-01' => 10,
//    '2010-01-02' => 3,
//    '2010-01-03' => 17
// );
// $data->addSeries('seo', $seoDataSeries);

$chart  = new Chart();
$chart->addOptions($options);
$chart->addOptions($titleOptions);
$chart->addOptions($extOptions);
$chart->setData($data);
$chart->setRenderer(new Pie());