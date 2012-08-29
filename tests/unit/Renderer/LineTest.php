<?php
/**
 * Tests for the Phighchart\Options\Line class
 */

namespace Phighchart\Test\Renderer;

use Phighchart\Chart;
use Phighchart\Options\Container as OptionsContainer;
use Phighchart\Options\ExtendedContainer as ExtendedOptionsContainer;
use Phighchart\Format\Datetime as DatetimeFormat;
use Phighchart\Data;
use Phighchart\Renderer\Line;

class LineTest extends \PHPUnit_Framework_TestCase
{
    public function testLineImplementsInterface()
    {
        $line = new Line();
        $this->assertInstanceOf('Phighchart\Renderer\RendererInterface', $line);
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
        $data->addSeries('Apples', array(
            '2012-05-01' => 12,
            '2012-05-02' => 3,
            '2012-05-03' => 33
        ))
        ->addSeries('Oranges', array(
            '2012-05-01' => 32,
            '2012-05-02' => 36,
            '2012-05-03' => 18
        ));

        // put it all together
        $chart  = new Chart();
        $chart->addOptions($options);
        $chart->addOptions($titleOptions);
        $chart->addOptions($extOptions);
        $chart->setData($data);
        $chart->setRenderer(new Line());

        // test the full expected output
        $this->assertSame(
            'var chart_example_59; chart_example_59 = new Highcharts.Chart({"chart":{"renderTo":"chart_example_59","marginRight":130,"marginBottom":25,"type":"line"},"title":{"text":"Monthly Details","x":-20},"xAxis":{"categories":["2012-05-01","2012-05-02","2012-05-03"]},"series":[{"name":"Apples","data":[12,3,33],"color":"#629632"},{"name":"Oranges","data":[32,36,18],"color":"#CD3700"}]});',
            $chart->render()
        );
        $this->assertSame('<div id="chart_example_59"></div>', $chart->renderContainer());
    }

    public function testRenderWithoutExtendedOptions()
    {
        $options = new OptionsContainer('chart');
        $options->setRenderTo('chart_example_59');
        $options->setMarginRight(130);
        $options->setMarginBottom(25);

        $titleOptions = new OptionsContainer('title');
        $titleOptions->setText('Monthly Details');
        $titleOptions->setX(-20);

        $data = new Data();
        $data->addSeries('Apples', array(
            '2012-05-01' => 12,
            '2012-05-02' => 3,
            '2012-05-03' => 33
        ))
        ->addSeries('Oranges', array(
            '2012-05-01' => 32,
            '2012-05-02' => 36,
            '2012-05-03' => 18
        ));

        // put it all together
        $chart  = new Chart();
        $chart->addOptions($options);
        $chart->addOptions($titleOptions);
        $chart->setData($data);
        $chart->setRenderer(new Line());

        // test the full expected output
        $this->assertSame(
            'var chart_example_59; chart_example_59 = new Highcharts.Chart({"chart":{"renderTo":"chart_example_59","marginRight":130,"marginBottom":25,"type":"line"},"title":{"text":"Monthly Details","x":-20},"xAxis":{"categories":["2012-05-01","2012-05-02","2012-05-03"]},"series":[{"name":"Apples","data":[12,3,33]},{"name":"Oranges","data":[32,36,18]}]});',
            $chart->render()
        );
        $this->assertSame('<div id="chart_example_59"></div>', $chart->renderContainer());
    }

    public function testRenderWithStandardDateTimeFormat()
    {
        $options = new OptionsContainer('chart');
        $options->setRenderTo('chart_example_59');
        $options->setMarginRight(130);
        $options->setMarginBottom(25);

        $titleOptions = new OptionsContainer('title');
        $titleOptions->setText('Monthly Details');
        $titleOptions->setX(-20);

        $data = new Data();
        $data->addSeries('Apples', array(
            '2012-05-01' => 12,
            '2012-05-02' => 3,
            '2012-05-03' => 33
        ))
        ->addSeries('Oranges', array(
            '2012-05-01' => 32,
            '2012-05-02' => 36,
            '2012-05-03' => 18
        ));

        // put it all together
        $chart  = new Chart();
        $chart->addOptions($options);
        $chart->addOptions($titleOptions);
        $chart->setData($data);
        $chart->setFormat(new DatetimeFormat());
        $chart->setRenderer(new Line());

        // test the full expected output
        $this->assertSame(
            'var chart_example_59; chart_example_59 = new Highcharts.Chart({"chart":{"renderTo":"chart_example_59","marginRight":130,"marginBottom":25,"type":"line"},"title":{"text":"Monthly Details","x":-20},"xAxis":{"type":"datetime"},"series":[{"name":"Apples","data":[[Date.UTC(2012,4,01,00,00,00),12],[Date.UTC(2012,4,02,00,00,00),3],[Date.UTC(2012,4,03,00,00,00),33]]},{"name":"Oranges","data":[[Date.UTC(2012,4,01,00,00,00),32],[Date.UTC(2012,4,02,00,00,00),36],[Date.UTC(2012,4,03,00,00,00),18]]}]});',
            $chart->render()
        );
        $this->assertSame('<div id="chart_example_59"></div>', $chart->renderContainer());
    }

    public function testRenderWithCustomDateTimeFormat()
    {
        $options = new OptionsContainer('chart');
        $options->setRenderTo('chart_example_59');
        $options->setMarginRight(130);
        $options->setMarginBottom(25);

        $titleOptions = new OptionsContainer('title');
        $titleOptions->setText('Monthly Details');
        $titleOptions->setX(-20);

        $data = new Data();
        $data->addSeries('Apples', array(
            '1st May, 2012 00:00:00' => 12, //non standard date time format
            '2nd May, 2012 00:00:00' => 3,
            '3rd May, 2012 00:00:00' => 33
        ))
        ->addSeries('Oranges', array(
            '1st May, 2012 00:00:00' => 32,
            '2nd May, 2012 00:00:00' => 36,
            '3rd May, 2012 00:00:00' => 18
        ));

        $format = new DatetimeFormat();
        $format->setDateTimeFormat('jS F, Y H:i:s');

        // put it all together
        $chart  = new Chart();
        $chart->addOptions($options);
        $chart->addOptions($titleOptions);
        $chart->setData($data);
        $chart->setFormat($format);
        $chart->setRenderer(new Line());

        // test the full expected output
        $this->assertSame(
            'var chart_example_59; chart_example_59 = new Highcharts.Chart({"chart":{"renderTo":"chart_example_59","marginRight":130,"marginBottom":25,"type":"line"},"title":{"text":"Monthly Details","x":-20},"xAxis":{"type":"datetime"},"series":[{"name":"Apples","data":[[Date.UTC(2012,4,01,00,00,00),12],[Date.UTC(2012,4,02,00,00,00),3],[Date.UTC(2012,4,03,00,00,00),33]]},{"name":"Oranges","data":[[Date.UTC(2012,4,01,00,00,00),32],[Date.UTC(2012,4,02,00,00,00),36],[Date.UTC(2012,4,03,00,00,00),18]]}]});',
            $chart->render()
        );
        $this->assertSame('<div id="chart_example_59"></div>', $chart->renderContainer());
    }
}
