<?php

namespace Phighchart\Test\Format;

use Phighchart\Chart;
use Phighchart\Format\Datetime;
use Phighchart\PropertyType\Raw;

/**
 * Unit tests for the Datetime format
 * @author Shahrukh Omar <shahrukhomar@gmail.com>
 */
class DatetimeTest extends \PHPUnit_Framework_TestCase
{
    //tests the datetime format class when given date times are in standard
    //Localized or ISO8601 Notations
    public function testStandardDatetimeChartData()
    {
        $seriesData = array(
            '2012-08-01 08:00:00' => 12,
            '02-08-2012'          => 3,
            '2012:08:03 18:11:31' => 33
        );

        $d = Raw::TYPE_RAW_DELIMITER;
        $expected  = array(
            $d.'[Date.UTC(2012,7,01,08,00,00),12]'.$d,
            $d.'[Date.UTC(2012,7,02,00,00,00),3]'.$d,
            $d.'[Date.UTC(2012,7,03,18,11,31),33]'.$d
        );

        $dateTime  = new Datetime();
        $formatted = $dateTime->getFormattedChartData($seriesData);
        $this->assertInternalType('array', $formatted);
        $this->assertSame($expected, $formatted);
    }

    //Tests the datetime format class with a non-standard custom date format
    public function testNonStandardDatetimeChartData()
    {
        $seriesData = array(
            '1st August, 2012 08:00:31' => 12,
            '2nd August, 2012 00:00:00' => 3,
            '3rd August, 2012 00:01:00' => 33
        );

        $d = Raw::TYPE_RAW_DELIMITER;
        $expected  = array(
            $d.'[Date.UTC(2012,7,01,08,00,31),12]'.$d,
            $d.'[Date.UTC(2012,7,02,00,00,00),3]'.$d,
            $d.'[Date.UTC(2012,7,03,00,01,00),33]'.$d
        );

        $dateTime  = new Datetime();
        $dateTime->setDateTimeFormat('jS F, Y H:i:s');
        $formatted = $dateTime->getFormattedChartData($seriesData);
        $this->assertInternalType('array', $formatted);
        $this->assertSame($expected, $formatted);
    }

    //Tests the string to js Date conversion function
    public function testStringToJsDateConversion()
    {
        $dateTime  = new Datetime();
        $ref       = new \ReflectionMethod($dateTime, '_convertStringToJsDate');
        $ref->setAccessible(true);

        $this->assertSame(
            'Date.UTC(2012,7,01,00,00,00)',
            $ref->invoke($dateTime, '2012-08-01'));

        $this->assertSame(
            'Date.UTC(2012,7,03,18,11,31)',
            $ref->invoke($dateTime, '2012:08:03 18:11:31'));

        //test non-standard date formats
        $dateTime->setDateTimeFormat('jS F, Y H:i:s');
        $this->assertSame(
            'Date.UTC(2012,7,01,18,11,31)',
            $ref->invoke($dateTime, '1st August, 2012 18:11:31'));

        $dateTime->setDateTimeFormat('d M y H:i:s');
        $this->assertSame(
            'Date.UTC(2012,7,01,00,00,00)',
            $ref->invoke($dateTime, '01 Aug 12 00:00:00'));
    }

    //tests the highchart xAxis format options
    public function testFormatOptions()
    {
        $chart    = new Chart();
        $datetime = new Datetime();

        $formatOptions = $datetime->getFormatOptions($chart);
        $this->assertInstanceOf('Phighchart\Options\Container', $formatOptions);

        $expected = new \StdClass();
        $expected->type = 'datetime';

        $this->assertEquals($expected, $formatOptions->getOptions());
        $this->assertSame('xAxis', $formatOptions->getOptionsType());
    }
}