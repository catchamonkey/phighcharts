<?php

namespace Phighchart\Renderer;

use Phighchart\Renderer\RendererInterface;
use Phighchart\Renderer\Base;
use Phighchart\Options\Container;
use Phighchart\Chart;

/**
 * Column Renderer
 * The Column renderer will output a Column chart
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
class Column extends Base implements RendererInterface
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
        $chartOptions->setType('column');
        $chart->addOptions($chartOptions);

        // prepare the data
        $series = array();

        //formatter for rendering this chart
        $format = $chart->getFormat();

        // for each series of data (a series is a line)
        foreach ($chart->getData()->getSeries() as $key => $seriesData) {
            // add each one to the chart along with a sticky colour if present
            $seriesItem         = new \StdClass();
            $seriesItem->name   = $key;
            $seriesItem->data   = $format->getFormattedChartData($seriesData);
            if ($colour = $this->_getStickyColour($chart, $key)) {
                $seriesItem->color  = $colour;
            }
            $series[] = $seriesItem;
        }

        if ($formatOptions = $format->getFormatOptions($chart)) {
            $chart->addOptions($formatOptions);
        }

        // get all the existing options
        $options            = $chart->getOptionsForOutput();
        // add the series data
        $options['series']  = $series;

        // send back the prepared chart JS
        return $this->outputJavaScript($chart, $options);
    }
}
