<?php
/**
 * Tests for the Phighchart\Options\Container class
 */

namespace Phighchart\Test\Renderer;

use Phighchart\Chart;
use Phighchart\Options\Container as OptionsContainer;
use Phighchart\Options\ExtendedContainer as ExtendedOptionsContainer;
use Phighchart\Data;
use Phighchart\Renderer\Pie;

class PieTest extends \PHPUnit_Framework_TestCase
{
    public function testPieImplementsInterface()
    {
        $pie = new Pie();
        $this->assertInstanceOf('Phighchart\Renderer\RendererInterface', $pie);
    }

    /**
     * @expectedException Exception
     */
    public function testInvalidRenderArgument()
    {
        $pie = new Pie();
        $pie->render(new \StdClass());
    }

    public function testRender()
    {
        $extOptions = new ExtendedOptionsContainer();
        $extOptions->setStickyColour('apples', '#629632');
        $extOptions->setStickyColour('oranges', '#CD3700');

        $options = new OptionsContainer('chart');
        $options->setRenderTo('chart_example_59');
        $options->setMarginRight(130);
        $options->setMarginBottom(25);

        $titleOptions = new OptionsContainer('title');
        $titleOptions->setText('Monthly Details');
        $titleOptions->setX(-20);

        $data = new Data();
        $data->addCount('Apples', 32);
        $data->addCount('Oranges', 68);

        // put it all together
        $chart  = new Chart();
        $chart->addOptions($options);
        $chart->addOptions($titleOptions);
        $chart->addOptions($extOptions);
        $chart->setData($data);
        $chart->setRenderer(new Pie());

        // test the full expected output
        $this->assertSame(
            'var chart; chart = new Highcharts.Chart({"chart":{"renderTo":"chart_example_59","marginRight":130,"marginBottom":25},"title":{"text":"Monthly Details","x":-20},"series":[{"type":"pie","data":[{"name":"Apples","y":32,"color":"#629632"},{"name":"Oranges","y":68,"color":"#CD3700"}]}]});',
            $chart->render()
        );
    }
}
