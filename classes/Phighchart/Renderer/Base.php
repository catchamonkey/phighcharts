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

    /**
     * Returns sticky colour for the given key if the extended options are set
     * and a sticky colour is defined for the given key.
     * @param  Chart  $chart Chart instances
     * @param  string $key   Key to get the sticky colour for
     * @return bool   FALSE if extended options not set or the sticky colour not
     * found string sticky colour if found for the given key
     * @author Shahrukh Omar <shahrukhomar@gmail.com>
     */
    protected function _getStickyColour(Chart $chart, $key)
    {
        //return False if the extended options are not set
        if (!$chart->getExtendedOptions()) {
            return FALSE;
        }
        //return the sticky colour if it is set for the given key
        if ($colour = $chart->getExtendedOptions()->getStickyColour($key)) {
            return $colour;
        }

        return FALSE;
    }
}
