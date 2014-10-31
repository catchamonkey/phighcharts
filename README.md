#Phighcharts [![Project Build Status](https://secure.travis-ci.org/catchamonkey/phighcharts.png?branch=master)](https://travis-ci.org/catchamonkey/phighcharts) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/59d71ee8-7c9c-411d-ac97-94acf3381dd7/small.png)](https://insight.sensiolabs.com/projects/59d71ee8-7c9c-411d-ac97-94acf3381dd7)
A PHP (Requires PHP 5.3) library for the Highcharts JavaScript charting library

##Installation

```sh
composer require "catchamonkey/phighcharts"
```

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

    // a line chart is similar, and our data container holds series data for this
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
for rendering the labels as datetime format, provide an instance of the format
class. Note: Phighchart uses the Linear format by default

```php
<?php

    use Phighchart\Format\Datetime;

    //set up chart and chart data
    $dateTimeFormat = new Datetime();
    $chart->setFormat($dateTimeFormat);

?>
```

The Datetime formatter will now attempt to parse the chart data keys as DateTime
objects. The Datetime format class can parse the standard PHP date time string
formats out-of-the-box.

See
 - http://no2.php.net/manual/en/datetime.formats.compound.php
 - http://no2.php.net/manual/en/datetime.formats.date.php

For parsing custom date time string formats, provide the datetime string pattern
to the Phighchart Datetime format class as follows:

```php
<?php

    use Phighchart\Format\Datetime;

    //set up chart and chart data
    $dateTimeFormat = new Datetime();
    //for parsing date time string of pattern "1st August, 2012 12:09:32"
    $dateTimeFormat->setDateTimeFormat('jS F, Y H:i:s');
    $chart->setFormat($dateTimeFormat);

?>
```

##Unit Tests

You can run the Unit Test suite with;

    phpunit -c . tests/
