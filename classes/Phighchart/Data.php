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
     * @return Data $this Current instance
     **/
    public function addCount($key, $count)
    {
        // count must be integer of float
        if (!is_integer($count) || is_float($count)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Count value must be integer or float, "
                    . "'%s' value is type '%s'", $key, gettype($count)
                )
            );
        }
        $this->_data['count'][$key] = $count;

        return $this;
    }

    /**
     * Returns any defined data in the 'count' key
     * @return Mixed, Array of count data if set, FALSE otherwise
     */
    public function getCounts()
    {
        $ret = FALSE;
        if (isset($this->_data['count'])) {
            $ret = $this->_data['count'];
        }

        return $ret;
    }

    /**
     * Returns a single count value by key if defined
     * @param  string $key The count key you want to retrieve
     * @return Mixed, Integer count if set, FALSE otherwise
     */
    public function getCount($key)
    {
        $ret = FALSE;
        if ( isset($this->_data['count'][$key]) ) {
            $ret = $this->_data['count'][$key];
        }

        return $ret;
    }

    /**
     * Returns the total count for all 'count' type data
     * @return Integer count of all 'count' type data, 0 default
     */
    public function getCountTotal()
    {
        $ret = 0;
        if (isset($this->_data['count'])) {
            foreach ($this->_data['count'] as $key => $count) {
                $ret += $count;
            }
        }

        return $ret;
    }

    /**
     * addSeries
     *
     * Adds a data series for the supplied key
     * @return Data $this Current instance
     **/
    public function addSeries($key, Array $series)
    {
        // all members of series, must be integer or float
        foreach ($series as $memberKey => $member) {
            if (!(is_float($member) || is_integer($member))) {
                throw new \InvalidArgumentException(
                    sprintf(
                        "All members of a series must be integer or float, "
                        . "member key '%s' has value of type '%s'", $memberKey, gettype($member)
                    )
                );
            }
        }
        $this->_data['series'][$key] = $series;

        return $this;
    }

    public function getSeries()
    {
        $ret = FALSE;
        if (isset($this->_data['series'])) {
            $ret = $this->_data['series'];
        }

        return $ret;
    }
}
