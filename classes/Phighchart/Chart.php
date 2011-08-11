<?php

namespace Phighchart;
use Phighchart\Options\Custom;
use Phighchart\Data\Data;
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
        $this->_renderer    = 'Phighchart\Renderer\Base';
        $this->_data        = FALSE;
    }

    public function setOptions(Custom $options)
    {
        $this->_options = $options;
    }

    public function setData(Data $data)
    {
        $this->_data = $data;
    }

    public function setRenderer(Renderer $renderer)
    {
        if (!class_exists($renderer))
        {
            throw new Exception("Renderer class does not exist", 1);
        }
        $this->_renderer = $renderer;
    }

    public function render()
    {
        return $this->_renderer->render($this);
    }
}