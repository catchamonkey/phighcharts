<?php

namespace Phighchart\Format;

use Phighchart\Chart;

/**
 * Phighchart label Format Interface
 * @author Shahrukh Omar <shahrukhomar@gmail.com>
 */
interface FormatInterface
{
    /**
     * Returns any chart options specific to this specific formatter
     * @param  Chart  $chart instance of current Chart object
     * @return Mixed, PhighChart/Option if this format has specific chart options
     * , boolean false otherwise
     */
    public function getFormatOptions(Chart $chart);

    /**
     * Returns the plottable, formatter chart data
     * @param  Array $seriesData Series data as given by the user
     * @return array plottable, formatted chart data
     */
    public function getFormattedChartData(Array $seriesData);
}
