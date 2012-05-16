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
        $this->assertTrue($chart->getOptionsType('test') instanceof Container);
    }

    public function testAddOptionsExtendedContainer()
    {
        $chart      = new Chart();
        $options    = new ExtendedContainer();
        $chart->addOptions($options);
        $this->assertTrue($chart->getExtendedOptions() instanceof ExtendedContainer);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddInvalidOptions()
    {
        $chart      = new Chart();
        $options    = new \StdClass();
        $chart->addOptions($options);
        $this->assert($chart->getExtendedOptions() instanceof ExtendedContainer);
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
        $this->assertTrue($chart->getExtendedOptions() instanceof ExtendedContainer);
    }

    public function testGetData()
    {
        $chart      = new Chart();
        $data       = new Data();
        $chart->setData($data);
        $this->assertTrue($chart->getData() instanceof Data);
    }

    public function testSetRenderer()
    {
        $chart      = new Chart();
        $renderer   = new Pie();
        $this->assertNull($chart->setRenderer($renderer));
    }

    /**
     * @expectedException Exception
     */
    public function testSetInvalidRenderer()
    {
        $chart      = new Chart();
        $renderer   = new \StdClass();
        $chart->setRenderer($renderer);
    }

    public function testSetRenderContainer()
    {
        $chart      = new Chart();
        $this->assertEquals($chart->renderContainer('chart_123'), '<div id="chart_123"></div>');
        $this->assertEquals($chart->renderContainer('chart_121', 'span'), '<span id="chart_121"></span>');
    }
}
