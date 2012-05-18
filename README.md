#Phighcharts ![Project Build Status](https://secure.travis-ci.org/catchamonkey/phighcharts.png)
A PHP (Requires PHP 5.3) library for the Highcharts JavaScript charting library

##What does it do?
Along with providing a nice OO interface to create your charts, it also
extends the functionality by adding such useful tools as "Sticky Keys"

###Sticky Keys
A sticky key, is a configuration option that allows you to always use the same colour
for certain keys.
For example, you may want to always use green for apples when charting apples vs oranges.

##Example Pie Chart

```php
<?php

    use Phighchart\Chart;
    use Phighchart\Options\Container;
    use Phighchart\Options\ExtendedContainer;
    use Phighchart\Data;
    use Phighchart\Renderer\Pie;
    use Phighchart\Renderer\Line;

    $extOptions = new ExtendedContainer();
    $extOptions->setStickyColour('apples', '#629632');
    $extOptions->setStickyColour('oranges', '#CD3700');

    $options = new Container('chart');
    $options->setRenderTo('chart_example_59');
    $options->setMarginRight(130);
    $options->setMarginBottom(25);

    $titleOptions = new Container('title');
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
    $options = new Container('chart');
    $options->setRenderTo('chart_example_60');
    $options->setMarginRight(130);
    $options->setMarginBottom(25);
    $lineChart->addOptions($options)->setRenderer(new Line());

    // and render in the template
    $chart->renderContainer();
    // or to change the element rendered
    // $chart->renderContainer('span');
    $chart->render();
    
    // and for the line
    $lineChart->renderContainer();
    $lineChart->render();
?>
```

##Unit Tests

You can run the Unit Test suite with;

    phpunit -c tests/ .