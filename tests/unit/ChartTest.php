<?php
/**
 * Tests for the Phighchart\Chart class
 */

namespace Phighchart\Test;

use Phighchart\Chart;
use Phighchart\Data;
use Phighchart\Options\Container;
use Phighchart\Options\ExtendedContainer;
use Phighchart\Renderer\Pie;

class ChartTest extends \PHPUnit_Framework_TestCase
{
    public function testAddOptionsContainer()
    {
        $chart      = new Chart();
        $options    = new Container('test');
        $options->setFoo('bar');
        $chart->addOptions($options);
        $this->assertInstanceOf('Phighchart\Options\Container', $chart->getOptionsType('test'));
    }

    public function testAddMultipleOptionsContainers()
    {
        $chart      = new Chart();
        $options    = new Container('test');
        $options->setFoo('bar');
        $options2   = new Container('test2');
        $options2->setFoo('bar1');
        $options2->setFoo2('bar2');
        $chart->addOptions(array($options, $options2));

        $this->assertInstanceOf('Phighchart\Options\Container', $chart->getOptionsType('test'));
        $this->assertInstanceOf('Phighchart\Options\Container', $chart->getOptionsType('test2'));
        $this->assertSame($chart->getOptionsType('test')->getOption('foo'), 'bar');
        $this->assertSame($chart->getOptionsType('test2')->getOption('foo'), 'bar1');
        $this->assertSame($chart->getOptionsType('test2')->getOption('foo2'), 'bar2');
    }

    public function testAddOptionsExtendedContainer()
    {
        $chart      = new Chart();
        $options    = new ExtendedContainer();
        $chart->addOptions($options);
        $this->assertInstanceOf('Phighchart\Options\ExtendedContainer', $chart->getExtendedOptions());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddInvalidOptions()
    {
        $chart      = new Chart();
        $options    = new \StdClass();
        $chart->addOptions($options);
        $this->assertInstanceOf('Phighchart\Options\ExtendedContainer', $chart->getExtendedOptions());
    }

    public function testGetOptionsForOutput()
    {
        $chart      = new Chart();
        $options    = new Container('test');
        $options->setFoo('bar');
        $chart->addOptions($options);
        $options2   = new Container('test2');
        $options2->setBoo('far');
        $chart->addOptions($options2);
        $optionsForOutput = $chart->getOptionsForOutput();
        $this->assertInternalType('array', $optionsForOutput);
        $this->assertSame($optionsForOutput['test']->foo, 'bar');
        $this->assertSame($optionsForOutput['test2']->boo, 'far');
    }

    public function testGetExtendedOptions()
    {
        $chart      = new Chart();
        $options    = new ExtendedContainer();
        $chart->addOptions($options);
        $this->assertInstanceOf('Phighchart\Options\ExtendedContainer', $chart->getExtendedOptions());
    }

    public function testGetData()
    {
        $chart      = new Chart();
        $data       = new Data();
        $chart->setData($data);
        $this->assertInstanceOf('Phighchart\Data', $chart->getData());
    }

    public function testSetRenderer()
    {
        $chart      = new Chart();
        $renderer   = new Pie();
        // setRenderer should return current chart instance
        $this->assertSame($chart, $chart->setRenderer($renderer));
    }

    public function testSetRenderContainer()
    {
        $chart      = new Chart();
        $options    = new Container('chart');
        $chart->setRenderer(new Pie());
        $options->setRenderTo('chart_123');
        $chart->addOptions($options);
        $this->assertEquals($chart->renderContainer(), '<div id="chart_123"></div>');
        $this->assertEquals($chart->renderContainer('span'), '<span id="chart_123"></span>');
    }
}
