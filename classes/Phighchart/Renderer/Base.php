<?php

namespace Phighchart\Renderer;

use Phighchart\Renderer\Interface;
use Phighchart\Chart;

/**
 * Base Renderer
 * The base renderer will output an example line chart to demonstrate how to
 * create your own custom chart renderer
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
class Base implements Interface
{
    public function render(Chart $chart)
    {
    }
}