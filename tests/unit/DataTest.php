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
}
