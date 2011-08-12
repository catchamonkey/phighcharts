<?php

namespace Phighchart;

/**
 * Holds the data for a chart instance
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
class Data
{
    private $_data;

    public function __construct()
    {
        $this->_data = array();
    }

    /**
     * addCount
     *
     * Adds a data count for the supplied key
     * @return NULL
     **/
    public function addCount($key, $count)
    {
        $this->_data[$key] = $count;
    }

    /**
     * addSeries
     *
     * Adds a data series for the supplied key
     * @return NULL
     **/
    public function addSeries($key, Array $series)
    {
        $this->_data[$key] = $series;
    }
}