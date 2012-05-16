<?php

namespace Phighchart\Renderer;

use Phighchart\Renderer\RendererInterface;
use Phighchart\Options\Container;
use Phighchart\Chart;

/**
 * Pie Renderer
 * The Pie renderer will output a Pie chart
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
class Pie implements RendererInterface
{
    /**
     * Creates and returns the JSON encoded chart details, options and data
     * from the injected Chart, generally called by the view layer
     * @param Chart $chart  Instance of Phighchart\Chart
     * @return String $ret  The JSON string to display the complete chart
     */
    public function render(Chart $chart)
    {
        // prepare the data
        $series = array();
        foreach ($chart->getData()->getCounts() as $key => $count)
        {
            // add each one to the chart along with a sticky colour if present
            if ($colour = $chart->getExtendedOptions()->getStickyColour($key, TRUE))
            {
                // complex sets must be a StdClass
                $seriesItem         = new \StdClass();
                $seriesItem->name   = $key;
                $seriesItem->y      = $count;
                $seriesItem->color  = $colour;
                $series[]           = $seriesItem;
            }
            else
            {
                // simple key value pairs can be passed in as an array
                $series[] = array($key, $count);
            }
        }
        // make it a pie chart and pass back in the prepared data
        $chartSeriesOptions = $chart->getOptionsType('series', new Container('series'));
        $chartSeriesOptions->setType('pie');
        $chartSeriesOptions->setData($series);
        // get all the existing options
        $ret            = $chart->getOptionsForOutput();
        // add the series as a nested array
        $ret['series']  = array($chartSeriesOptions->getOptions());

        return "chart = new Highcharts.Chart(".json_encode($ret).");";
    }
}