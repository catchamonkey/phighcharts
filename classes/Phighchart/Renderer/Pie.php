<?php

namespace Phighchart\Renderer;

use Phighchart\Renderer\ChartInterface;
use Phighchart\Renderer\Base;
use Phighchart\Chart;

/**
 * Pie Renderer
 * The Pie renderer will output a Pie chart
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
class Pie extends Base implements ChartInterface
{
    public function render(Chart $chart)
    {
        foreach ($chart->getData()->getCounts() as $key => $count)
        {
            // add each one to the chart along with a sticky colour if present
            if ($colour = $chart->getOptions()->getStickyColour($key))
            {
                
            }
            $this->addToJavaScript('JavaScriptStrings');
        }
        return $this->getJavaScript();
    }
}