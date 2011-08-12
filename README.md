#Phighcharts
A PHP library for the Highcharts JavaScript charting library

##What does it do?
Along with providing a nice OOP interface to create your charts, it also
extends the functionality by adding such useful tools as

###Adding a colour to be used by a certain key of data
This will ensure that the same colour is used consistently for data with the same key

##Example

    use Phighchart\Chart;
    use Phighchart\Options\Defaults;
    use Phighchart\Data;
    use Phighchart\Renderer\Pie;

    $options    = new Defaults();
    $options->addStickyColour('seo', '#8f8f8f');
    $options->addStickyColour('ppc', '#3c3c3c');

    $data       = new Data();
    $data->addCount('seo', 200);
    $data->addCount('ppc', 150);

    // or for a series chart (line/spline etc)
    $data           = new Data();
    $seoDataSeries  = array(
        '2010-01-01' => 10,
        '2010-01-02' => 3,
        '2010-01-03' => 17
    );
    $data->addSeries('seo', $seoDataSeries);

    $chart      = new Chart();
    $chart->setOptions($options);
    $chart->setData($data);
    $chart->setRenderer('Pie');

    // in the template
    $chart->render();