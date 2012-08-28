<?php

namespace Phighchart\Renderer;

use Phighchart\Renderer\RendererInterface;
use Phighchart\Renderer\Base;
use Phighchart\Options\Container;
use Phighchart\Chart;

/**
 * Area chart renderer
 * Returns render for an area chart
 * @author  Shahrukh Omar <shahrukhomar@gmail.com>
 */
class Area extends Base implements RendererInterface
{
    public function render(Chart $chart)
    {
        //set the chart type to area
        $chartSection = $chart->getOptionsType('chart', new Container('chart'));
        $chartSection->setType('area');
        $chart->addOptions($chartSection);

        //prepare series array
        $series = array();

        //formatter for rendering this chart
        $format = $chart->getFormat();

        foreach ($chart->getData()->getSeries() as $key => $seriesData) {
            $member       = new \StdClass();
            $member->name = $key;
            $member->data = $format->getFormattedChartData($seriesData);
            //check if a sticky colour is defined for the key of this member
            if ($colour = $this->_getStickyColour($chart,$key)) {
                $member->color = $colour;
            }
            //commit member to the series
            $series[] = $member;
        }

        if ($formatOptions = $format->getFormatOptions($chart)) {
            $chart->addOptions($formatOptions);
        }

        //return the series data
        $options = $chart->getOptionsForOutput();
        $options['series'] = $series;

        return $this->outputJavaScript($chart, $options);
    }
}