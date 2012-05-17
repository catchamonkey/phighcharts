#Phighcharts
A PHP (Requires PHP 5.3) library for the Highcharts JavaScript charting library

##What does it do?
Along with providing a nice OOP interface to create your charts, it also
extends the functionality by adding such useful tools as "Sticky Keys"

###Sticky Keys
A sticky key, is a configuration option that allows you to always use the same colour
for certain keys.
For example, you may want to always use green for apples when charting apples vs oranges.

##Example Pie Chart

```php
<?php

    use Phighchart\Chart;
    use Phighchart\Options\Container as OptionsContainer;
    use Phighchart\Options\ExtendedContainer as ExtendedOptionsContainer;
    use Phighchart\Data;
    use Phighchart\Renderer\Pie;

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
        ->addCount('Oranges', 68);

    // put it all together
    $chart  = new Chart();
    $chart
        ->addOptions($options)
        ->addOptions($titleOptions)
        ->addOptions($extOptions)
        ->setData($data)
        ->setRenderer(new Pie());

    // and render in the template
    $chart->renderContainer('chart_example_59'); // optional second argument for element type
    $chart->render();
?>
```

##Unit Tests

You can run the Unit Test suite with;

    phpunit -c tests/ .