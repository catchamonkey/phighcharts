<?php

namespace Phighchart\Test\Format;

use Phighchart\Data;
use Phighchart\Chart;
use Phighchart\Format\Linear;
use Phighchart\Renderer\Area;

class LinearTest extends \PHPUnit_Framework_TestCase
{
    //tests the formatted chart data for the linear format
    public function testLinearChartData()
    {
        $seriesData = array(
            '01-08-2012' => 12,
            '02-08-2012' => 3,
            '03-08-2012' => 33
        );

        $expected  = array(12, 3, 33);

        $linear    = new Linear();
        $formatted = $linear->getFormattedChartData($seriesData);
        $this->assertInternalType('array', $formatted);
        $this->assertSame($expected, $formatted);
    }

    public function testFormatOptions()
    {
        $data = new Data();
        $data->addSeries('Test', array(
            '01-08-2012' => 18,
            '02-08-2012' => 4,
            '03-08-2012' => 12
        ));

        $chart = new Chart();
        $chart->setData($data);
        $chart->setRenderer(new Area());

        $linear = new Linear();
        $formatOptions = $linear->getFormatOptions($chart);
        $this->assertInstanceOf('Phighchart\Options\Container', $formatOptions);

        $expected = new \StdClass();
        //for linear format the xAxis labels are set as categories
        $expected->categories = array(
            '01-08-2012',
            '02-08-2012',
            '03-08-2012'
        );

        $this->assertEquals($expected, $formatOptions->getOptions());
        $this->assertSame('xAxis', $formatOptions->getOptionsType());
    }
}