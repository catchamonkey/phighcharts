<?php

namespace Phighchart\Renderer;

use Phighchart\Renderer\RendererInterface;
use Phighchart\Renderer\Base;
use Phighchart\Options\Container;
use Phighchart\Chart;

/**
 * Line Renderer
 * The Line renderer will output a Line chart
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
class Line extends Base implements RendererInterface
{
    /**
     * Creates and returns the JSON encoded chart details, options and data
     * from the injected Chart, generally called by the view layer
     * @param  Chart  $chart Instance of Phighchart\Chart
     * @return String $ret  The JSON string to display the complete chart
     */
    public function render(Chart $chart)
    {
        // make it a line chart
        $chartOptions = $chart->getOptionsType('chart', new Container('chart'));
        $chartOptions->setType('line');
        $chart->addOptions($chartOptions);

        // prepare the data
        $series = array();
        // for each series of data (a series is a line)
        foreach ($chart->getData()->getSeries() as $key => $seriesData) {
            // add each one to the chart along with a sticky colour if present
            $seriesItem         = new \StdClass();
            $seriesItem->name   = $key;
            $seriesItem->data   = array_values($seriesData);
            if ($colour = $this->_getStickyColour($chart, $key)) {
                $seriesItem->color  = $colour;
            }
            $series[] = $seriesItem;
        }

        // create the X-Axis categories from the last seen series
        $xAxis = $chart->getOptionsType('xAxis', new Container('xAxis'));
        $xAxis->setCategories(array_keys($seriesData));
        // add to the chart
        $chart->addOptions($xAxis);

        // get all the existing options
        $options            = $chart->getOptionsForOutput();
        // add the series data
        $options['series']  = $series;

        // send back the prepared chart JS
        return $this->outputJavaScript($chart, $options);
    }
}
