<?php

namespace Phighchart\Options;

/**
 * Defines custom Phighchart Options
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
class Custom
{
    private $_options;

    public function __construct()
    {
        $this->_options = array();
    }

    /**
     * Sets a colour that will always be used when data with this key is charted
     * @param String $key The key to store this colour for
     * @param String $colour The colour to store
     */
    public function addStickyColour($key, $colour)
    {
        if (!is_string($key) || !is_string($colour))
        {
            throw new InvalidArgumentException("Key and Colour must be strings", 1);
        }
        $this->_options['colours']['sticky'][$key] = $colour;
    }

    /**
     * Retrieves a sticky colour by key
     * @param String $key The key of the colour you want to retrieve
     * @return Mixed String colour on success, Boolean FALSE on failure
     */
    public function getStickyColour($key)
    {
        return ($this->_options['colours']['sticky'][$key]) ?: FALSE;
    }
}