<?php
/**
 * Tests for the Phighchart\Data class
 */

namespace Phighchart\Test;

use Phighchart\Data;

class DataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Checks the addCount, getCount and getCounts method
     */
    public function testCount()
    {
        $data = new Data();
        $this->assertSame($data, $data->addCount('seo', 100));
        $this->assertSame($data, $data->addCount('ppc', 12));
        $this->assertSame(100, $data->getCount('seo'));
        $this->assertFalse($data->getCount('iDontExist'));
        $this->assertNotSame(13, $data->getCount('ppc'));
        $this->assertInternalType('array', $data->getCounts());
        $this->assertInternalType('integer', $data->getCount('ppc'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidCount()
    {
        $data           = new Data();
        $data->addCount('seo', 123);
        $data->addCount('seo', 'bar');
    }

    public function testGetCountTotal()
    {
        $data           = new Data();
        $data->addCount('seo', 123);
        $data->addCount('ppc', 23);
        $this->assertSame(146, $data->getCountTotal());
    }

    public function testGetNoCountTotal()
    {
        $data           = new Data();
        $this->assertSame(0, $data->getCountTotal());
    }

    public function testSeries()
    {
        $data           = new Data();
        $seoDataSeries  = array(
            '2010-01-01' => 10,
            '2010-01-02' => 3,
            '2010-01-03' => 17
        );
        $this->assertSame($data, $data->addSeries('seo', $seoDataSeries));
        $this->assertSame(array('seo' => $seoDataSeries), $data->getSeries());
        $this->assertInternalType('array', $data->getSeries());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidSeries()
    {
        $data           = new Data();
        $seoDataSeries  = array(
            '2010-01-01' => 10,
            '2010-01-02' => '3',
            '2010-01-03' => 17
        );
        $data->addSeries('seo', $seoDataSeries);
    }
}
