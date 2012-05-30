<?php

namespace Phighchart\Renderer;

use Phighchart\Chart;

/**
 * Renderer Base
 * Provides shared functionality required by all renderer implementations
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
abstract class Base
{
    /**
     * Creates and returns the JavaScript variables and Highcharts instance
     * @param  Chart  $chart   Instance of Phighchart\Chart
     * @param  Array  $options The full set of options for this chart
     * @return String $ret  The JSON string to display the complete chart
     */
    public function outputJavaScript(Chart $chart, Array $options)
    {
        // use the renderTo id as the JS variable name
        $jsVar = $this->getRenderTo($chart);

        return "var ".$jsVar."; ".$jsVar." = new Highcharts.Chart(".json_encode($options).");";
    }

    /**
     * Renders the chart container
     * @param  String $type The type of HTML element the container should be
     * @return String An HTML element of defined type, with defined unique ID
     */
    public function renderContainer(Chart $chart, $type = 'div')
    {
        $renderTo = $this->getRenderTo($chart);

        return '<'.$type.' id="'.$renderTo.'"></'.$type.'>';
    }

    /**
     * Retrieves the renderTo option from the 'chart' options
     * @return String     $renderTo The renderTo option from the 'chart' options
     * @throws \Exception chart options or renderTo is not set
     */
    public function getRenderTo(Chart $chart)
    {
        // fetch the renderTo option
        if (
            (!$options = $chart->getOptionsType('chart')) ||
            (!$renderTo = $options->getOption('renderTo'))
        ) {
            throw new \Exception(
                "Render To option within chart options must be defined (renderTo)", 1
            );
        }

        return $renderTo;
    }
}
