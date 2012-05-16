<?php

namespace Phighchart\Options;
use Phighchart\Options\Container;

/**
 * Defines default Phighchart Options
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
class Defaults extends Container
{
    public function __construct()
    {
        parent::__construct('chart');
        // setup the container and apply our defaults
        // direct is always grey
        $this->setStickyColour('direct', '#efefef');
    }
}