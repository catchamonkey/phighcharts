<?php

namespace Phighchart\Renderer;
use Phighchart\Chart;

/**
 * Chart Renderer Interface
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
interface RendererInterface
{
    public function render(Chart $chart);
}