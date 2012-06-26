<?php

namespace Phighchart;

use Phighchart\Options\Container;
use Phighchart\Options\ExtendedContainer;
use Phighchart\Data;
use Phighchart\Renderer\RendererInterface;
use Exception;

/**
 * Container for data, configuration and renderer classes
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
class Chart
{
    private $_options;
    private $_extendedOptions;
    private $_renderer;
    private $_data;

    public function __construct()
    {
        $this->_options         = array();
        $this->_extendedOptions = FALSE;
        $this->_renderer        = FALSE;
        $this->_data            = FALSE;
    }

    /**
     * The options to use when rendering this chart
     * @param  Container|ExtendedContainer $options stocked instance of chart options
     * @return Chart                       $this Current instance
     * @throws \InvalidArgumentException   if wrong instance type passed in
     */
    public function addOptions($options)
    {
        if ($options instanceof Container) {
            $this->_options[$options->getOptionsType()] = $options;
        } elseif ($options instanceof ExtendedContainer) {
            $this->_extendedOptions = $options;
        } elseif (is_array($options)) {
            foreach ($options as $option) {
                $this->addOptions($option);
            }
        } else {
            throw new \InvalidArgumentException(
                "Options must be instance of Container or ExtendedContainer", 1
            );
        }

        return $this;
    }

    /**
     * Returns the current options array
     * @return Mixed, Array of options (Container|ExtendedContainer) if any
     * present, or FALSE
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Returns the current options as an array of StdClass's
     * @return Mixed, Array of options StdClass if any present, or FALSE
     */
    public function getOptionsForOutput()
    {
        $ret = FALSE;
        if ($this->_options) {
            $ret = array();
            foreach ($this->_options as $type => $options) {
                $ret[$type] = $options->getOptions();
            }
        }

        return $ret;
    }

    /**
     * Returns a single set of options by type
     * @param  String $type The type of options you want to retrieve
     * @return Mixed, Container|ExtendedContainer if present, or $default if not (Default:FALSE)
     */
    public function getOptionsType($type, $default = FALSE)
    {
        $ret = $default;
        if (isset($this->_options[$type])) {
            $ret = $this->_options[$type];
        }

        return $ret;
    }

    /**
     * Returns the current extended options instance
     * @return Mixed, Phighchart\Options\ExtendedContainer $_extendedOptions if set, FALSE otherwise
     */
    public function getExtendedOptions()
    {
        return $this->_extendedOptions;
    }

    /**
     * The Data to use when rendering this chart
     * @param  Phighchart\Data $data stocked instance of chart data
     * @return Chart           $this Current instance
     */
    public function setData(Data $data)
    {
        $this->_data = $data;

        return $this;
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
     * @param $renderer Renderer class instance
     * @return Chart $this Current instance
     */
    public function setRenderer(RendererInterface $renderer)
    {
        $this->_renderer = $renderer;

        return $this;
    }

    /**
     * Renders the chart container
     * @param  String $type The type of HTML element the container should be
     * @return The    response of renderContainer() of $this->_renderer
     */
    public function renderContainer($type = 'div')
    {
        return $this->_renderer->renderContainer($this, $type);
    }

    /**
     * Outputs the current chart instance
     * @return The response of render() of $this->_renderer
     */
    public function render()
    {
        // before we render we must have options and data
        if (!$this->_options || !$this->_data || !$this->_renderer) {
            throw new Exception(
                "Before rendering you must provide data, options and a renderer", 1
            );
        }

        return $this->_renderer->render($this);
    }
}
