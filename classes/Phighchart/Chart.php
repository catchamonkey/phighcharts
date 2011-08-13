<?php

namespace Phighchart;

use Phighchart\Options\Custom as Options;
use Phighchart\Data;
use Phighchart\Renderer\Base as Renderer;

/**
 * Container for data, configuration and renderer classes
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
class Chart
{
    private $_options;
    private $_renderer;
    private $_data;

    public function __construct()
    {
        $this->_options     = FALSE;
        $this->_renderer    = FALSE;
        $this->_data        = FALSE;
    }

    /**
     * The options to use when rendering this chart
     * @param Phighchart\Options\Custom $options stocked instance of chart options
     */
    public function setOptions(Options $options)
    {
        $this->_options = $options;
    }

    /**
     * Returns the current options instance
     * @return Mixed, Phighchart\Options\Custom $_options if set, FALSE otherwise
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * The Data to use when rendering this chart
     * @param Phighchart\Data $data stocked instance of chart data
     */
    public function setData(Data $data)
    {
        $this->_data = $data;
    }

    /**
     * Returns the current data instance
     * @return Mixed, Phighchart\Data $_data if set, FALSE otherwise
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * The Renderer to use when rendering this chart
     * @param $renderer Renderer class that implements the Phighchart\Renderer\Interface
     */
    public function setRenderer($renderer)
    {
        if (!class_exists($renderer))
        {
            throw new \InvalidArgumentException("Renderer class does not exist", 1);
        }
        $this->_renderer = new $renderer();
    }

    /**
     * Outputs the current chart instance
     * @return The response of render() of $this->_renderer 
     */
    public function render()
    {
        // before we render we must have options and data
        if (!$this->_options || !$this->_data || !$this->_renderer)
        {
            throw new Exception("Before rendering you must provide data, options and a renderer", 1);
        }
        return $this->_renderer->render($this);
    }
}