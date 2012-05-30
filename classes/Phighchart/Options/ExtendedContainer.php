<?php

namespace Phighchart\Options;

/**
 * Container for Extended Phighchart Options (options not directly supported
 * by highcharts, but implemented in PHP and translated to highcharts)
 * There is only one instance of this ExtendedContainer in each Chart
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
class ExtendedContainer
{
    private $_options;

    public function __construct()
    {
        $this->_options                 = new \StdClass();
        $this->_options->stickyColours  = array();
    }

    /**
     * Sets a colour that will always be used when data with this key is charted
     * @param String $key    The key to store this colour for
     * @param String $colour The colour to store
     */
    public function setStickyColour($key, $colour)
    {
        if (!is_string($key) || !is_string($colour)) {
            throw new \InvalidArgumentException(
                "Key and Colour must be strings", 1
            );
        }
        $this->_options->stickyColours[strtolower($key)] = $colour;
    }

    /**
     * Retrieves a sticky colour by key
     * @param  String  $key    The key of the colour you want to retrieve
     * @param  Boolean $remove Whether to remove this colour so it's not used again
     * @return Mixed   String colour on success, Boolean FALSE on failure
     */
    public function getStickyColour($key, $remove = FALSE)
    {
        $ret = false;
        $key = strtolower($key);
        if (isset($this->_options->stickyColours[$key])) {
            $ret = $this->_options->stickyColours[$key];
        }
        if ($remove) {
            unset($this->_options->stickyColours[$key]);
        }

        return $ret;
    }
}
