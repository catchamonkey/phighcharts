<?php

namespace Phighchart\Format;

use Phighchart\Chart;
use Phighchart\Options\Container;
use Phighchart\Format\FormatInterface;

/**
 * Standard linear chart plot format
 * @author  Shahrukh Omar <shahrukhomar@gmail.com>
 */
class Linear implements FormatInterface
{
    /**
     * Sets the xAxis category labels for the linear chart plots
     * @param  Chart  $chart instance of the current Chart object
     * @return Mixed Phighchart\Container if the series data is set, boolean false otherwise
     */
    public function getFormatOptions(Chart $chart)
    {
        $data = $chart->getData();
        if ($data && $seriesData = $data->getSeries()) {
            $xAxis = $chart->getOptionsType('xAxis', new Container('xAxis'));
            // create the X-Axis categories from the last seen series
            $xAxis->setCategories(array_keys(array_pop($seriesData)));

            return $xAxis;
        }

        return false;
    }

    /**
     * Returns the plottable chart data
     * @param  Array $seriesData
     * @return Array
     */
    public function getFormattedChartData(Array $seriesData)
    {
        return array_values($seriesData);
    }
}
