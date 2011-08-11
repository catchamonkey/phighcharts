#Phighcharts
A PHP library for the Highcharts JavaScript charting library

##What does it do?
The library extends the functionality by adding such useful tools as

###Adding a colour to be used by a certain key of data
This will ensure that the same colour is used consistently for data with the same key

    use Phighchart\Chart;
    use Phighchart\Options\Defaults;
    use Phighchart\Data\Data;
    use Phighchart\Renderer\Pie;

    $options    = new Defaults();
    $options->addStickyColour('seo', '#8f8f8f');
    $options->addStickyColour('ppc', '#3c3c3c');

    $data       = new Data;
    $data->addDataTotal('seo', 200);
    $data->addDataTotal('ppc', 150);

    $chart      = new Chart();
    $chart->setOptions($options);
    $chart->setData($data);
    $chart->setRenderer('Pie');

    // in the template
    $chart->render();