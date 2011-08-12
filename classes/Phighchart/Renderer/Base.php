<?php

namespace Phighchart\Renderer;

/**
 * Base Renderer
 * The base renderer will provides methods useful to specific renderer classes
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
class Base
{
    private $_javascript;

    public function __construct()
    {
        $this->_javascript = '';
    }

    public function getJavaScript()
    {
        return $this->_javascript;
    }

    public function addToJavaScript($js)
    {
        $this->_javascript .= $js;
    }
}