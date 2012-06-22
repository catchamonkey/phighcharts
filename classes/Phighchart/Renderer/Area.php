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

        foreach ($chart->getData()->getSeries() as $key => $seriesData) {
            $member = new \StdClass();
            $member->name = $key;
            $member->data = array_values( $seriesData );
            //check if a sticky colour is defined for the key of this member
            if ($colour = $this->_getStickyColour($chart,$key)) {
                $member->color = $colour;
            }
            //commit member to the series
            $series[] = $member;
        }

        //create labels for xAxis based on the last seen series data
        $xAxis = $chart->getOptionsType('xAxis', new Container('xAxis'));
        $xAxis->setCategories(array_keys($seriesData));
        $chart->addOptions($xAxis);

        //return the series data
        $options = $chart->getOptionsForOutput();
        $options['series'] = $series;

        return $this->outputJavaScript($chart, $options);
    }

    private function _getStickyColour( Chart $chart, $key )
    {
        if(!$chart->getExtendedOptions()) {
            return FALSE;
        }

        if($colour = $chart->getExtendedOptions()->getStickyColour($key)) {
            return $colour;
        }

        return FALSE;
    }
}