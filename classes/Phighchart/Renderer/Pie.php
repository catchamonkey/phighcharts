<?php

namespace Phighchart\Renderer;

use Phighchart\Renderer\RendererInterface;
use Phighchart\Renderer\Base;
use Phighchart\Options\Container;
use Phighchart\Chart;

/**
 * Pie Renderer
 * The Pie renderer will output a Pie chart
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
class Pie extends Base implements RendererInterface
{
    /**
     * Creates and returns the JSON encoded chart details, options and data
     * from the injected Chart, generally called by the view layer
     * @param  Chart  $chart Instance of Phighchart\Chart
     * @return String $ret  The JSON string to display the complete chart
     */
    public function render(Chart $chart)
    {
        // prepare the data
        $series = array();
        foreach ($chart->getData()->getCounts() as $key => $count) {
            // add each one to the chart along with a sticky colour if present
            if ($colour = $chart->getExtendedOptions()->getStickyColour($key)) {
                // complex sets must be a StdClass
                $seriesItem         = new \StdClass();
                $seriesItem->name   = $key;
                $seriesItem->y      = $count;
                $seriesItem->color  = $colour;
            } else {
                // simple key value pairs can be passed in as an array
                $seriesItem         = array($key, $count);
            }
            $series[] = $seriesItem;
        }
        // make it a pie chart and pass back in the prepared data
        $chartSeriesOptions = $chart->getOptionsType('series', new Container('series'));
        $chartSeriesOptions->setType('pie');
        $chartSeriesOptions->setData($series);
        // get all the existing options
        $options            = $chart->getOptionsForOutput();
        // add the series as a nested array
        $options['series']  = array($chartSeriesOptions->getOptions());

        // send back the prepared chart JS
        return $this->outputJavaScript($chart, $options);
    }
}
