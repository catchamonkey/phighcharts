<?php

namespace Phighchart\Renderer;
use Phighchart\Chart;

/**
 * Renderer Interface
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
interface ChartInterface
{
    public function render(Chart $chart);
}