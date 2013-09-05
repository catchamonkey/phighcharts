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
        if ($chart->getData()->getCounts()) {
            // prepare the data
            $series = array();
            foreach ($chart->getData()->getCounts() as $key => $count) {
                // prepare the series item
                $seriesItem = new \StdClass();
                $seriesItem->name = $key;
                $seriesItem->y    = $count;
                // add the sticky colour if present
                if ($colour = $this->_getStickyColour($chart, $key)) {
                    $seriesItem->color  = $colour;
                }
                // add to the series
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

        return '';
    }
}
